<br><br>

<table>
    <tr>
        <th>Название</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($records as $dt): ?>
    <tr>
        <td><?= $dt->name ?></td>
    </tr>
    <?php endforeach; ?>
</table>