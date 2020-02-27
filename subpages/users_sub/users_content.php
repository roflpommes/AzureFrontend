<div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Content Row -->
        <div class="row justify-content-center">

            <!-- Content Column -->
            <div class="col">

                <div class="card shadow mb-1">
                    <?php

                        //Choose if list of users is displayed, or the "modify users" page
                        if(isset($_GET['user']))
                        {
                            include_once('./subpages/users_sub/users_content_properties.php');
                        }

                        else include_once('./subpages/users_sub/users_content_list.php');

                    ?>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

</div>
