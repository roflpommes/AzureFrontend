<div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row justify-content-center">

            <!-- Content Column -->
            <div class="col">

                <!-- Project Card Example -->
                <div class=" card shadow mb-4">
                    <?php

                        if(isset($_GET['group']))
                        {
                            include_once('./subpages/groups_sub/groups_content_properties.php');
                        }

                        else include_once('./subpages/groups_sub/groups_content_list.php');

                    ?>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

</div>
