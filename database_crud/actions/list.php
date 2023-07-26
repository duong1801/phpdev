<?php
$limit = 3;
$get  = isset($_GET)?$_GET:false;

$filter = "";
if(!empty($get['status'])){
    if($get['status'] == 'active' || $get['status'] == 'inactive') {
        $status = $get['status'] == 'active'? 1: 0 ;
        $filter .= getOperator($filter).' status='.$status;
      
    }
}


if(!empty($get['group_id'])){
    $groupId = $get['group_id'];
    $filter.= getOperator($filter). ' group_id='.$groupId;
    
}

if(!empty($get['keyword'])){
    $keyword = $get['keyword'];
    $filter.= getOperator($filter)." (users.name LIKE '%".$keyword."%' OR users.username LIKE '%".$keyword."%')";
}

$users = get("SELECT users.*,user_groups.name AS group_name FROM users INNER JOIN user_groups ON users.group_id = user_groups.id $filter ORDER BY id DESC");

$groups = get("SELECT * FROM user_groups");

// dd($groups);


?>


<h1 class="my-4">Danh sách người dùng</h1>
<br>
<form action="" class="mb-3">
    <div class="row">
        <div class="col-3">
            <select name="status" class="form-select" id="">
                <option value="all">Tất cả trạng thái</option>
                <option value="active" 
                <?php
                 echo !empty($get['status']) && $get['status'] == 'active'? 'selected':false;
                
                 ?>
                > 
                Kích hoạt
                </option>
                <option value="inactive"
                <?php echo !empty($get['status']) && $get['status'] == 'inactive'? 'selected':false; ?>
                
                >
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
                        $selected = !empty($get['group_id']) && $get['group_id'] == $group['id']?'selected':'' ;
                        echo  " <option value='{$group['id']}' {$selected}>{$group['name']}</option>";
                    }
                }

                ?>
            </select>
        </div>
        <div class="col-4">
            <input type="search" name="keyword" class="form-control" placeholder="Từ khóa..." value="<?php echo $get['keyword']??false ?>" />
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
                <td><?php echo $user['username'] ?></td>
                <td><?php echo $user['phone'] ?></td>
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

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <?php

        ?>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
</nav>