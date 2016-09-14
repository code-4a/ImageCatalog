
<table>
    <tr>
        <th>Название</th>
        <th>Путь</th>
        <th>Создан</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($records as $image): ?>
    <tr>
        <td><a href="/images/<?= $image->id ?>"><?= $image->name ?></a></td>
        <td><?= $image->path ?></td>
        <td><?= $image->created ?></td>
        <td><a href="/images/<?= $image->id ?>/edit">Edit</a></td>
        <td><a href="/images/<?= $image->id ?>/delete">Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<br><br>
<a href="/images/add">Добавить</a>
<br>
<a href="/images/find">Поиск</a>