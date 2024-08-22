<?php
/* get last review info in this file. */
$lastReview = $this->repo->getLastReviewInfo($file);
$repoModule = isset($lastReview) && isset($lastReview->module) ? $lastReview->module : '';

/* Get product pairs. */
if($repo->product)
{
    $products = $this->dao->select('id,name')->from(TABLE_PRODUCT)->where('`id`')->in($repo->product)->fetchPairs();
}
else
{
    $products = $this->loadModel('product')->getPairs('', 0, '', 'all');
}

/* get product by cookie or last review in this file. */
$repoProduct = isset($_COOKIE['repoPairs'][$repoID]) ? $_COOKIE['repoPairs'][$repoID] : '';
$repoProduct = isset($lastReview) && isset($lastReview->product) ? $lastReview->product : $repoProduct;
$repoProduct = isset($products[$repoProduct]) ? $repoProduct : key($products);
$executions  = $this->repo->getExecutionPairs($repoProduct);
$modules     = $this->loadModel('tree')->getOptionMenu($repoProduct, $viewType = 'bug', $startModuleID = 0);
$users       = $this->loadModel('user')->getPairs('devfirst|nodeleted|noclosed');
$products    = array('' => '') + $products;
$executions  = array('' => '') + $executions;

$cwd         = getcwd();
$commiters   = $this->user->getCommiters();
$blamePairs  = array();
if($suffix and $suffix != 'binary' and strpos($this->config->repo->images, "|$suffix|") === false)
{
    $blames = $this->scm->blame($entry, $info->revision);
    foreach($blames as $line => $blame)
    {
        if(!isset($blame['committer']))
        {
            if(isset($blamePairs[$line - 1])) $blamePairs[$line] = $blamePairs[$line - 1];
            continue;
        }
        $blamePairs[$line] = zget($commiters, $blame['committer'], $blame['committer']);
    }
}
chdir($cwd);

$infoRevision    = isset($info->revision) ? $info->revision : '';
$v1              = isset($oldRevision) ? str_replace('-', '*', $oldRevision) : 0;
$v2              = str_replace('-', '*', $infoRevision);
$reviews         = $this->repo->getReview($repoID, $file, $v2);
$bugUrl          = $this->repo->createLink('addBug', "repoID=$repoID&file=$file&v1=$v1&v2=$v2");
$commentUrl      = $this->repo->createLink('addComment');
$productSelect   = html::select('product', $products, $repoProduct, 'class="product form-control chosen" onchange="changeProduct(this)"');
$branches        = $this->loadModel('branch')->getPairs($repoProduct);
$moduleSelect    = html::select('module', $modules, $repoModule, 'class="form-control chosen"');
$executionSelect = html::select('execution', $executions, '', 'class="form-control chosen"');
$typeSelect      = html::select('repoType', $lang->repo->typeList, '', 'class="form-control chosen"');
$userSelect      = html::select('assignedTo', $users, '', 'class="form-control chosen assignedTo"');
$bugs = array();
foreach($reviews as $line => $lineReview)
{
    $lineBugs = array();
    foreach ($lineReview['bugs'] as $bugID => $bug)
    {
        $lineBug                            = array();
        $lineBug['id']                      = $bugID;
        $lineBug['line']                    = $line;
        $lineBug['title']                   = $bug->title;
        $lineBug['steps']                   = $bug->steps;
        $lineBug['realname']                = $bug->realname;
        $lineBug['openedDate']              = substr($bug->openedDate, 5, 11);
        $lineBug['lines']                   = $bug->lines;
        $lineBug['file']                    = $bug->entry;
        if($bug->edit) $lineBug['edit']     = true;
        if(!empty($bug->delete)) $lineBug['delete'] = true;

        if(isset($lineReview['comments']))
        {
            if(isset($lineReview['comments'][$bugID]))
            {
                $comments    = $lineReview['comments'][$bugID];
                $bugComments = array();
                foreach ($comments as $commentID => $comment)
                {
                    $bugComment = array(
                        'id'       => $comment->id,
                        'edit'     => $comment->edit,
                        'realname' => $comment->realname,
                        'user'     => $comment->user,
                        'date'     => substr($comment->date, 5, 11),
                        'comment'  => $comment->comment,
                    );
                    $bugComments[] = $bugComment;
                }
                $lineBug['comments'] = $bugComments;
            }
        }
        $lineBugs[] = $lineBug;
    }

    $bugs[$line] = $lineBugs;
}

$browser = helper::getBrowser();
js::set('browser', $browser['name']);
js::set('bugs', $bugs);
js::set('productError', $lang->repo->error->product);
js::set('contentError', $lang->repo->error->commentText);
js::set('titleError', $lang->repo->error->title);
js::set('commentError', $lang->repo->error->comment);
js::set('submit', $lang->repo->submit);
js::set('cancel', $lang->repo->cancel);
js::set('confirmDelete', $lang->repo->notice->deleteBug);
js::set('confirmDeleteComment', $lang->repo->notice->deleteComment);
js::set('repoID', $repoID);
js::set('revision', $infoRevision);
js::set('file', $file);
js::set('blamePairs', $blamePairs);
js::set('isonlybody', isonlybody());
?>
<?php if(common::hasPriv('repo', 'addBug')):?>
<form id="bugForm" class="bugForm main-form hide" method="post" action="<?php echo $bugUrl?>">
  <div class="bugFormContainer">
    <table class='table table-form'>
      <tr>
        <?php if($this->app->tab == 'project' && $objectID):?>
        <?php echo html::hidden('project', $objectID);?>
        <?php endif;?>
        <th><?php echo $lang->repo->product?></th>
        <td>
          <div class='input-group'>
          <?php echo $productSelect;?>
          <?php if($branches) echo html::select('branch', $branches, '', "class='form-control' style='width:95px' onchange='loadBranch(this)'");?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->repo->execution?></th>
        <td>
          <div class='input-group'>
            <?php echo $executionSelect;?>
            <span class="input-group-addon fix-border"><?php echo $lang->repo->module;?></span>
            <?php echo $moduleSelect?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->repo->title?></th>
        <td><?php echo html::input('title', '', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->repo->type?></th>
        <td><?php echo $typeSelect?></td>
      </tr>
      <tr>
        <th><?php echo $lang->repo->assign?></th>
        <td><?php echo $userSelect?></td>
      </tr>
      <tr>
        <th><?php echo $lang->repo->lines?></th>
        <td class='lines'>
          <div class="input-group">
            <input class="line form-control" type="number" min="1" name="begin">
            <span class="input-group-addon fix-border">-</span>
            <input class="line form-control" type="number" min="1" name="end">
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->repo->detile?></th>
        <td><textarea id="commentText" name="commentText" class="commentInput form-control" spellcheck="false"></textarea></td>
      </tr>
      <tr>
        <td colspan="2" class='form-actions text-center'>
          <?php echo html::hidden('entry');?>
          <?php echo html::submitButton($lang->repo->submit, '', 'btn btn-wide btn-primary bugSubmit');?>
          <?php echo html::commonButton($lang->cancel, "onclick='hiddenForm()'", 'btn btn-wide');?>
        </td>
      </tr>
    </table>
    <div class="optional"></div>
  </div>
</form>
<?php else:?>
<form id='bugForm' class='bugForm hide'>
<?php printf($lang->user->errorDeny, $lang->repo->common, $lang->repo->addBug);?>
</form>
<?php endif;?>

<div class='panel panel-sm hide panel-bug' id='bugPanel'>
  <div class='panel-heading'>
    <div class="bug-title">
      <i class='icon-bug text-muted'></i>
      <?php if(common::hasPriv('bug', 'view')):?>
      <a href='javascript:;' class='view-bug' target='_blank'>Bug #<span class='bugid'></span></a>
      <?php else:?>
      Bug #<span class='bugid'></span>
      <?php endif;?>
      <span class="bug-lines"><?php echo $lang->repo->lines?> <strong class='code-lines'></strong></span>
    </div>
    <div class='panel-actions pull-right'>
      <?php if(common::hasPriv('bug', 'edit')):?>
      <a href='javascript:;' target='_blank' class='edit bugEdit' data-width="95%"><i class='icon icon-pencil'></i></a>
      <?php endif;?>
      <?php if(common::hasPriv('repo', 'deleteBug')):?>
      <a href='javascript:;' class='delete bugDelete'><i class='icon icon-remove'></i></a>
      <?php endif;?>
      <a href="javascript:;"><i class='icon-chevron-down'></i></a>
    </div>
  </div>
  <?php if(common::hasPriv('repo', 'addComment')):?>
  <div class='panel-body'>
    <div class='comments'></div>
    <button class='btn btn-sm addComment' type='button'><?php echo $lang->repo->addComment?></button>
    <form class='commentForm not-watch' method='post' action='<?php echo $commentUrl?>' id='commentForm'>
      <textarea name='comment' class='commentText form-control mgb-10' spellcheck='false' placeholder='<?php echo $lang->repo->notice->commentContent?>'></textarea>
      <input class='commentSubmit btn btn-sm btn-primary' type='submit' value='<?php echo $lang->repo->submit?>'>
      <input class='commentCancel btn btn-sm' type='button' value='<?php echo $lang->repo->cancel?>'>
      <input type='hidden' name='objectID' value=''>
      <div class='optional'></div>
    </form>
  </div>
  <?php endif;?>
</div>
<div class='comment hide' id='commentCell'>
  <div>
    <span class="avatar has-img avatar-circle pull-left"></span>
    <span class='text-muted comment-date'>&nbsp;
      <i class='icon-time'></i>
      <span class='date'></span>
    </span>
    <a href='javascript:;' class='edit commentEdit pull-right'>
      <i class='icon-pencil'></i>
    </a>
  </div>
  <div>
    <strong class='realname'></strong>
    <strong> <?php echo $lang->repo->commited . ' ' . $lang->repo->comment;?></strong>
  </div>
  <strong class='comment-content text-content'></strong>
  <div class="comment-form-div">
    <form method='post' class='comment-edit-form not-watch' action=''>
      <textarea name='commentText' class='commentInput form-control mgb-10'></textarea>
      <button type='submit' class='btn btn-sm btn-primary commentEditSubmit'><?php echo $lang->repo->submit?></button>
      <button type='button' class='btn btn-sm commentEditCancel'><?php echo $lang->repo->cancel?></button>
    </form>
  </div>
</div>
<div class='dropdown' id="bugsPreview">
  <ul class='dropdown-menu fade'>
    <li class='dropdown-header'><?php echo $lang->repo->line?><strong class='code-line'></strong> &nbsp; <i class='icon-bug'></i> <strong class='bug-count'>0</strong> &nbsp; <i class='icon-comments-alt'></i> <strong class='comment-count'>0</strong></li>
  </ul>
</div>
<div id='rowTip' class='hide'><div class='row-tip'><i class='icon-chat preview-icon'></i><div class='on-expand tip'><span><?php echo $lang->repo->expand?> </span><i class='icon-chevron-down'></i></div><div class='on-collapse tip'><span><?php echo $lang->repo->collapse?> </span><i class='icon-chevron-up'></i></div></div></div>
<script>
function changeProduct(select)
{
    loadProductBranches(select);
    productID = $(select).children('option:selected').val();
    link = createLink('repo', 'ajaxGetExecutions', 'productID=' + productID);
    $.get(link, function(data)
    {
        $(select).closest('.bugFormContainer').find('#execution_chosen').remove();
        $(select).closest('.bugFormContainer').find('select[name=execution]').replaceWith(data);
        $(select).closest('.bugFormContainer').find('select[name=execution]').chosen();
    })
    moduleLink = createLink('tree', 'ajaxGetOptionMenu', 'productID=' + productID + '&viewtype=bug&branch=0&rootModuleID=0&returnType=html');
    $.get(moduleLink, function(data)
    {
        $(select).closest('.bugFormContainer').find('#module_chosen').remove();
        $(select).closest('.bugFormContainer').find('select[name=module]').replaceWith(data).chosen();
        $(select).closest('.bugFormContainer').find('select[name=module]').chosen();
    })
}

function loadProductBranches(select)
{
    $(select).closest('.input-group').find('#branch').remove();
    productID = $(select).children('option:selected').val();
    $.get(createLink('branch', 'ajaxGetBranches', "productID=" + productID), function(data)
    {
        if(data)
        {
            $(select).closest('.input-group').append(data);
            $(select).closest('.input-group').find('#branch').css('width', '95px');
        }
    });
}

function loadBranch(select)
{
    branch = $(select).val();
    productID = $(select).closest('.input-group').find('#product').val();
    link = createLink('repo', 'ajaxGetExecutions', 'productID=' + productID + '&branch=' + branch);
    $.get(link, function(data)
    {
        $(select).closest('.bugFormContainer').find('#execution_chosen').remove();
        $(select).closest('.bugFormContainer').find('select[name=execution]').replaceWith(data);
        $(select).closest('.bugFormContainer').find('select[name=execution]').chosen();
    })
    moduleLink = createLink('tree', 'ajaxGetOptionMenu', 'productID=' + productID + '&viewtype=bug&branch=' + branch + '&rootModuleID=0&returnType=html');
    $.get(moduleLink, function(data)
    {
        $(select).closest('.bugFormContainer').find('#module_chosen').remove();
        $(select).closest('.bugFormContainer').find('select[name=module]').replaceWith(data).chosen();
        $(select).closest('.bugFormContainer').find('select[name=module]').chosen();
    })
}

function hiddenForm()
{
    if(browser == 'ie') $('.with-action-row').removeClass('with-action-row');
    if(browser != 'ie')
    {
        var widgetid = $('#bugForm').parent().attr('widgetid');
        if(!widgetid) return;

        var line = parseInt(widgetid.substr(7));

        $('#bugForm').parent().remove();
        editor.changeViewZones(function (changeAccessor) {
            changeAccessor.removeZone(viewZoneId);
        });

        editor.revealLine(line);
    }
}

/* remove a function */
function loadModuleRelated(){}
</script>
