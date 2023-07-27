<?php
$limit = 2;
$page = null;
$get  = isset($_GET) ? $_GET : false;

$filter = "";
if (!empty($get['status'])) {
    if ($get['status'] == 'active' || $get['status'] == 'inactive') {
        $status = $get['status'] == 'active' ? 1 : 0;
        $filter .= getOperator($filter) . ' status=' . $status;
    }
}


if (!empty($get['group_id'])) {
    $groupId = $get['group_id'];
    $filter .= getOperator($filter) . ' group_id=' . $groupId;
}

if (!empty($get['keyword'])) {
    $keyword = $get['keyword'];
    $filter .= getOperator($filter) . " (users.name LIKE '%" . $keyword . "%' OR users.email LIKE '%" . $keyword . "%')";
}




// dd($groups);

$tottalRow = getRows("SELECT id FROM users $filter");


$maxPage = ceil($tottalRow / $limit);

if (!empty(($get['page'])) && filter_var($get['page'], FILTER_VALIDATE_INT, [
    "options" => [
        'min_range' => 1,
        'max_range' => $maxPage
    ]
]) !== false) {
    $page = $get['page'];
} else {
    $page = 1;
}




$offSet = ($page - 1) * $limit;
$users = get("SELECT users.*,user_groups.name AS group_name FROM users INNER JOIN user_groups ON users.group_id = user_groups.id $filter
 ORDER BY id DESC LIMIT $limit OFFSET $offSet");

$groups = get("SELECT * FROM user_groups");



?>


<h1 class="my-4">Danh sách người dùng</h1>
<br>
<form action="" class="mb-3">
    <div class="row">
        <div class="col-3">
            <select name="status" class="form-select" id="">
                <option value="all">Tất cả trạng thái</option>
                <option value="active" <?php
                                        echo !empty($get['status']) && $get['status'] == 'active' ? 'selected' : false;

                                        ?>>
                    Kích hoạt
                </option>
                <option value="inactive" <?php echo !empty($get['status']) && $get['status'] == 'inactive' ? 'selected' : false; ?>>
                    Chưa kích hoạt
                </option>
            </select>
        </div>
        <div class="col-3">
            <select name="group_id" class="form-select" id="">
                <option value="0">Tất cả nhóm</option>
                <?php

                if (!empty($groups)) {
                    foreach ($groups as $key => $group) {
                        $selected = !empty($get['group_id']) && $get['group_id'] == $group['id'] ? 'selected' : '';
                        echo  " <option value='{$group['id']}' {$selected}>{$group['name']}</option>";
                    }
                }

                ?>
            </select>
        </div>
        <div class="col-4">
            <input type="search" name="keyword" class="form-control" placeholder="Từ khóa..." value="<?php echo $get['keyword'] ?? false ?>" />
        </div>
        <div class="col-2 d-grid">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </div>
</form>
<table class="table table-primary">

    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Nhóm</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Ngày chỉnh sửa</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $index => $user) : ?>
            <tr>
                <th scope="row"><?php echo $index + 1 ?></th>
                <td><?php echo $user['name'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['phone'] ?></td>
                <td><?php echo $user['group_name'] ?></td>
                <td><?php echo getDateFormat($user['created_at'], 'H:i:s d/m/y') ?></td>
                <td><?php echo getDateFormat($user['updated_at'], 'H:i:s d/m/y') ?></td>
                <td>
                    <button class="btn btn-warning">Sửa</button>
                    <button class="btn btn-danger">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
<?php if ($maxPage > 1) : ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <!-- <?php if ($page > 1) : ?>
                <li class="page-item"><a class="page-link" href="<?php echo getPaginateUrl($page - 1) ?>">Previous</a></li>
            <?php endif ?>

            <?php
            for ($i = 1; $i <= $maxPage; $i++) :
            ?>

                <li class='page-item'><a class='page-link' href='<?php echo getPaginateUrl($i) ?>'><?php echo $i ?></a></li>

            <?php
            endfor
            ?>

            <?php if ($page < $maxPage) : ?>
                <li class="page-item"><a class="page-link" href="<?php echo getPaginateUrl($page + 1) ?>">Next</a></li>
            <?php endif; ?> -->
            <?php

            $limit = 3;

            $link = "";
            if ($maxPage >= 1 && $page <= $maxPage) {
                $counter = 1;
                $link = "";
                if ($page > ($limit / 2)) {
                    $link .= "<li  class='page-item me-4'><a class='page-link' href=\"" . getPaginateUrl(1) . "\">1 </a></li>";
                }
                for ($x = $page; $x < $maxPage; $x++) {

                    if ($counter < $limit) {

                        $link .= "<li class='page-item'><a  class='page-link' href=\"" . getPaginateUrl($x) . "\">" . $x . " </a></li>";
                    }

                    $counter++;
                }
                if ($page < $maxPage - ($limit / 2))
                    $link .= "<li  class='page-item ms-4'><a class='page-link' href=\"" . getPaginateUrl($maxPage) . "\">" . $maxPage . " </a></li>";
            }


            echo $link;
            ?>

        </ul>
    </nav>
<?php endif; ?>