
<table>
    <tr>
        <th>Название</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($records as $tag): ?>
    <tr>
        <td><a href="/tags/<?= $tag->id ?>"><?= $tag->name ?></a></td>
        <td><a href="/tags/<?= $tag->id ?>/edit">Edit</a></td>
        <td><a href="/tags/<?= $tag->id ?>/delete">Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<br><br>
<a href="/tags/add">Добавить</a>
<br>
<a href="/tags/find">Поиск</a>