<?php /** @var $user User */ ?>

<div class="container" style="margin-top: 50px">

    <div class="col col-sm-6">

        <div class="panel">

            <div class="panel-body">

                <table class="table table-condensed table-hover">

                    <thead>
                        <tr>
                            <th>username</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach (User::find() as $user) { ?>
                            <tr>
                                <td><?=$user->username?></td>
                                <td class="actions">
                                    <a href="<?=BASE_PATH?>/user/delete/<?=$user->id?>"><i class="fa fa-times"></i></a>&nbsp;
                                    <a href="javascript:void(0)" data-user="<?=$user->id?>" data-username="<?=$user->username?>"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="col col-sm-6">

        <div class="panel">
            <div class="panel-body">

                <form action="<?=BASE_PATH?>/user/save" method="POST">

                    <!-- username -->
                    <div class="form-group">
                        <label class="control-label" for="username">Email</label>
                        <input class="form-control" type="email" name="username" id="username" placeholder="Email" value="" />
                    </div>

                    <!-- password -->
                    <div class="form-group">
                        <label class="control-label" for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="" value="" />
                    </div>

                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" role="button">Save</button>

                </form>
                
            </div>
        </div>

    </div>

</div>