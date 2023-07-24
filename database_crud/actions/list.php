<?php

const PER_PAGE = 3;


$sql = 'SELECT * FROM users';

if(isset($_GET['search'])){
    $keyword = $_GET['keyword'];
    $sql = "SELECT * FROM users WHERE name LIKE '%$keyword%'";
}
$users = get($sql);
$record = getRows($sql);
$pagination = ceil($record/PER_PAGE);

//pagination

if(!empty($_GET['page'])){
    
}


?>


<h1 class="my-4">Danh sách người dùng</h1>
<form action="" class="my-4 d-flex justify-content-end">
    <div class="my-4 d-flex">
        <div class="me-4">
            <input name="keyword" value="<?php echo !empty($keyword)?$keyword:'' ?>" class="form-control" type="text" placeholder="Nhập từ khóa">
        </div>
        <button class="btn btn-primary" name="search" type="submit">Tìm kiếm</button>
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
    <?php foreach ($users as $index => $user): ?>
        <tr>
            <th scope="row"><?php echo $index + 1 ?></th>
            <td><?php echo $user['name'] ?></td>
            <td><?php echo $user['username'] ?></td>
            <td><?php echo $user['phone'] ?></td>
            <td><?php echo $user['created_at'] ?></td>
            <td><?php echo $user['updated_at'] ?></td>
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
            for($i = 1; $i <= $pagination;$i++){
                echo  '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
            }
        ?>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
</nav>