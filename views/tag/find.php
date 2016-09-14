

<table>
    <?php foreach ($records as $tag): ?>
    <tr>
        <td>Название:</td>
        <td><?= $tag->name ?></td>
    </tr>
    <?php endforeach; ?>
</table>

