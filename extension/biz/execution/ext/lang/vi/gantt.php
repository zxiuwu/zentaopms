<?php
$lang->execution->editrelation  = 'Quản lý mối quan hệ nhiệm vụ';
$lang->execution->maintainRelation = 'Quản lý mối quan hệ';
$lang->execution->deleterelation   = 'Xóa mối quan hệ';
$lang->execution->viewrelation  = 'Xem mối quan hệ';
$lang->execution->ganttchart    = 'Biểu đồ Gantt';

$lang->execution->gantt    = new stdclass();
$lang->execution->gantt->common  = 'Biểu đồ Gantt';
$lang->execution->gantt->id   = 'ID';
$lang->execution->gantt->pretask = 'Nhiệm vụ';
$lang->execution->gantt->condition  = 'Hành động';
$lang->execution->gantt->task    = 'Nhiệm vụ';
$lang->execution->gantt->action  = 'Hành động';
$lang->execution->gantt->type    = 'Loại';
$lang->execution->gantt->exportImg  = 'Xuất ra Image';
$lang->execution->gantt->exportPDF  = 'Xuất ra PDF';
$lang->execution->gantt->exporting  = 'Đang xuất...';
$lang->execution->gantt->exportFail = 'Xuất thất bại.';

$lang->execution->gantt->createRelationOfTasks = 'Thêm mối quan hệ nhiệm vụ';
$lang->execution->gantt->newCreateRelationOfTasks = 'Thêm mối quan hệ nhiệm vụ';
$lang->execution->gantt->editRelationOfTasks   = 'Sửa mối quan hệ nhiệm vụ';
$lang->execution->gantt->relationOfTasks    = 'Xem mối quan hệ nhiệm vụ';
$lang->execution->gantt->relation     = 'Mối quan hệ nhiệm vụ';
$lang->execution->gantt->showCriticalPath   = 'Hiện đường chính';
$lang->execution->gantt->hideCriticalPath   = 'Ẩn đường chính';
$lang->execution->gantt->fullScreen      = 'Toàn màn hình';

$lang->execution->gantt->zooming['day']   = 'Ngày';
$lang->execution->gantt->zooming['week']  = 'Tuần';
$lang->execution->gantt->zooming['month'] = 'Tháng';

$lang->execution->gantt->assignTo  = 'Giao cho';
$lang->execution->gantt->duration  = 'Thời gian';
$lang->execution->gantt->comp   = 'Tiến độ';
$lang->execution->gantt->startDate = 'Bắt đầu';
$lang->execution->gantt->endDate   = 'Kết thúc';
$lang->execution->gantt->days   = ' ngày';
$lang->execution->gantt->format = 'Định dạng';

$lang->execution->gantt->preTaskStatus['']   = '';
$lang->execution->gantt->preTaskStatus['end']   = 'đã kết thúc, sau đó';
$lang->execution->gantt->preTaskStatus['begin'] = 'đã bắt đầu, sau đó';

$lang->execution->gantt->taskActions[''] = '';
$lang->execution->gantt->taskActions['begin'] = 'có thể bắt đầu.';
$lang->execution->gantt->taskActions['end']   = 'có thể kết thúc.';

$lang->execution->gantt->color[0] = 'bbb';
$lang->execution->gantt->color[1] = 'ff5d5d';
$lang->execution->gantt->color[2] = 'ff9800';
$lang->execution->gantt->color[3] = '16a8f8';
$lang->execution->gantt->color[4] = '00da88';

$lang->execution->gantt->browseType['type']    = 'Loại nhiệm vụ';
$lang->execution->gantt->browseType['module']  = 'Module';
$lang->execution->gantt->browseType['assignedTo'] = 'giao cho';
$lang->execution->gantt->browseType['story']   = 'câu chuyện';

$lang->execution->gantt->confirmDelete = 'Bạn có muốn xóa mối quan hệ này?';
$lang->execution->gantt->tmpNotWrite   = 'Không thể ghi';

$lang->execution->gantt->warning     = new stdclass();
$lang->execution->gantt->warning->noEditSame  = "Nhiệm vụ trước và sau ID đang tồn tại %s nên giống nhau.";
$lang->execution->gantt->warning->noEditRepeat   = "Nhiệm vụ quan hệ giữa ID đang tồn tại %s và ID %s được nhân bản!";
$lang->execution->gantt->warning->noEditContrary = "Nhiệm vụ quan hệ giữa ID đang tồn tại %s và ID %s xung đột!";
$lang->execution->gantt->warning->noRepeat    = "Nhiệm vụ quan hệ giữa ID đang tồn tại %s và ID đã thêm %s được nhân bản!";
$lang->execution->gantt->warning->noContrary  = "Nhiệm vụ quan hệ giữa ID đang tồn tại %s và ID đã thêm %s xung đột!";
$lang->execution->gantt->warning->noNewSame   = "Nhiệm vụ trước và sau ID đã thêm %s nên giống nhau.";
$lang->execution->gantt->warning->noNewRepeat = "Nhiệm vụ quan hệ giữa ID đã thêm %s và ID %s được nhân bản!";
$lang->execution->gantt->warning->noNewContrary  = "Nhiệm vụ quan hệ giữa ID đã thêm %s và ID %s xung đột!";
