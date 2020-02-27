<div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Content Row -->
        <div class="row justify-content-center">

            <!-- Content Column -->
            <div class="col">

                <!-- Project Card Example -->
                <div class="card shadow mb-1">
                    <?php

                        if(isset($_GET['project']))
                        {
                            include_once('./subpages/projects_sub/projects_content_properties.php');
                        }

                        else include_once('./subpages/projects_sub/projects_content_list.php');

                    ?>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

</div>