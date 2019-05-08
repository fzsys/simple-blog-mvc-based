<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header"><? echo $title ?></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-10">
                        <?php if (empty($list)): ?>
                            <p>You have no posts yet</p>
                        <?php else: ?>
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <th>Change</th>
                                    <th>Delete</th>
                                </tr>
                                <?php foreach ($list as $val): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($val['name'], ENT_QUOTES); ?></td>
                                        <td><a href="/admin/edit/<?php echo $val['id']; ?>"
                                               class="btn btn-primary">Edit</a></td>
                                        <td><a href="/admin/delete/<?php echo $val['id']; ?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php echo $pagination; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>