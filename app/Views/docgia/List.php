<?php require_once __DIR__."/../header.php"; ?>


<h1>Danh sach doc gia</h1>

<a href="index.php?modun=Docgia&action=create">Thêm mới độc giả</a>

<table>
<tr>
    <th>Mã độc giả</th>
    <th>Tên độc giả</th>
    <th>NGày sinh</th>
    <th>Giới tính</th>
    <th>Số điện thoại</th>
    <th>Địa chỉ</th>
    <th colspan="2">Hành động</th>
</tr>
<?php foreach ($dsDocGia as $doc_gia): ?>
    <tr>
        <td><?= $doc_gia->ma_doc_gia; ?></td>
        <td><?= $doc_gia->ho_ten; ?></td>
        <td><?= $doc_gia->ngay_sinh; ?></td>
        <td><?= $doc_gia->gioi_tinh; ?></td>
        <td><?= $doc_gia->so_dien_thoai; ?></td>
        <td><?= $doc_gia->dia_chi; ?></td>
        <td><a href="index.php?modun=Docgia&action=update&id_docgia=<?= $doc_gia->id_doc_gia; ?>">Sửa</a></td>
        <td><a href="">Xóa</a></td>
    </tr>
<?php endforeach;?> 
</table>

<?php require_once __DIR__."/../footer.php"; ?>