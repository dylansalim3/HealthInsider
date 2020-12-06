<?php
session_start();
$page = 'inventory';
require('check-session.php');
require('db_staff_header.php');
require_once "php/staff_inventory.php";
?>


<?php foreach ($inventories as $inventory) : ?>

    <!-- modal to add stock -->
    <!--php inventory id-->
    <div class="modal fade" id="add<?php echo $inventory['NO'] ?>">
        <div class="modal-dialog " id="small-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <!-- php inventory name-->
                    <h4 class="modal-title">Item : <span><?php
                            echo $inventory['DRUG'];
                            ?></span></h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-center">
                    <div class="form-group row justify-content-center">
                        <!-- form id addForm-->
                        <form class="col-xs-2" action="db_staff_inventory.php"
                              id="addForm<?php echo $inventory['NO'] ?>"
                              method="post">
                            <label for="number">How many stock you want to add ?</label>
                            <input class="form-control" id="number" type="number" name="num" value="1" min="1">
                            <!-- php inventory NO-->
                            <input type="number" name="add" value="<?php
                            echo $inventory['NO'];
                            ?>" style="display: none">
                        </form>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                    <!-- js addButton() submit form-->
                    <button class="btn btn-primary" type="submit" form="addForm<?php echo $inventory['NO'] ?>">
                        Confirm
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- end of modal to add stock -->


    <!-- modal to minus stock -->
    <div class="modal fade" id="minus<?php echo $inventory['NO']; ?>">">
        <div class="modal-dialog " id="small-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <!-- php inventory name-->
                    <h4 class="modal-title">Item :
                        <span id="minusNo">
                        <?php echo $inventory['DRUG']; ?>
                    </span>
                    </h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-center">
                    <div class="form-group row justify-content-center">
                        <!-- form id minusForm-->
                        <form class="col-xs-2" id="minusForm<?php echo $inventory['NO'] ?>" method="post">
                            <label for="number">How many stock you want to minus ?</label>
                            <input class="form-control" id="number" name="num" type="number" value="1" min="1">
                            <!--php inventory NO-->
                            <input type="number" name="minus" value="<?php echo $inventory['NO']; ?>"
                                   style="display: none">
                        </form>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                    <!-- js minusButton() submit form-->
                    <button class="btn btn-primary" type="submit" form="minusForm<?php echo $inventory['NO'] ?>">
                        Confirm
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- end of modal to minus stock -->


    <!-- modal to edit item -->
    <div aria-hidden="true" aria-labelledby="tablesetting" class="modal fade" id="edit<?php echo $inventory['NO']; ?>">
        role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit inventory details</h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm<?php echo $inventory['NO'] ?>" action="" method="post">
                        <input type="number" style="display: none" name="edit" value="<?php echo $inventory['NO'] ?>">
                        <div class="form-group">
                            <label class="col-form-label" for="message-text">Drug:</label>
                            <input class="form-control" id="message-text" type="text" name="drug" value="<?php
                            echo $inventory['DRUG'];
                            ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="message-text2">Description:</label>
                            <textarea class="form-control" id="message-text2" name="desc" required><?php
                                echo $inventory['DESC'];
                                ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="message-text3">Cost:</label>
                            <input class="form-control" name="cost" id="message-text3" type="number" value="<?php
                            echo $inventory['COST'];
                            ?>" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-primary" type="submit" form="editForm<?php echo $inventory['NO'] ?>">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal to edit item -->


    <!-- modal to delete-->
    <div class="modal fade" id="delete<?php echo $inventory['NO']; ?>">
        <div class="modal-dialog " id="small-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Item
                        <span id="serialNo"><?php echo $inventory['NO']; ?></span>
                    </h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete item ?</div>
                <form class="modal-footer" action="db_staff_inventory.php" method="post">
                    <input type="number" style="display: none;" name="delete" value="<?php echo $inventory['NO'] ?>">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">No</button>
                    <button class="btn btn-primary" type="submit">Yes</button>
                </form>
            </div>
        </div>
    </div>
    <!-- end of delete modal -->

<?php endforeach; ?>

<!-- create inventory modal -->
<div aria-hidden="true" aria-labelledby="tablesetting" class="modal fade" id="create" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Inventory</h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
<!--                action empty post back to itself-->
                <form id="create1" action="" method="post">
                    <div class="form-group">
                        <label class="col-form-label" for="message-text">Drug:</label>
                        <input class="form-control" id="message-text" type="text" name="drug" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="message-text2">Description:</label>
                        <textarea class="form-control" id="message-text2" name="desc" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="message-text3">Cost:</label>
                        <input class="form-control" id="message-text3" type="number" name="cost" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="message-text5">Stock:</label>
                        <input class="form-control" id="message-text5" type="number" name="stock" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-primary" type="submit" name="create" form="create1">
                    Add
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end of create inventory modal -->


<!-- tables -->
<section>
    <div class="container-fluid">
        <div class="row mt-md-5 mb-5">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row align-items-center">
                    <div class="col" style="overflow-x:auto;">
                        <div class="d-flex justify-content-between align-items-center ml-2 mr-2 mt-2">
                            <h3 class="text-muted text-center mb-3">Inventory</h3>
                            <button class="btn btn-secondary" data-target="#create" data-toggle="modal" title="Setting"
                                    type="button">
                                <i class="fas fa-plus"></i>
                            </button>

                        </div>
                        <table class="table table-striped bg-light text-center align-items-center mt-2">
                            <thead>
                            <tr class="text-muted">
                                <th>SerialNo</th>
                                <th>Drug</th>
                                <th>Description</th>
                                <th>Cost</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            <?php foreach ($inventories as $inventory) : ?>
                                <tr>
                                    <th><?php
                                        echo $inventory['NO'];
                                        ?></th>
                                    <td><?php
                                        echo $inventory['DRUG'];
                                        ?></td>
                                    <td><?php
                                        echo $inventory['DESC']
                                        ?></td>
                                    <td><?php
                                        echo $inventory['COST']
                                        ?></td>
                                    <td><?php
                                        echo $inventory['STOCK']
                                        ?></td>
                                    <td style="display: flex;">
                                        <button class="btn" data-target="#add<?php echo $inventory['NO']; ?>"
                                                data-toggle="modal" type="button">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="btn" data-target="#minus<?php echo $inventory['NO']; ?>"
                                                data-toggle="modal" type="button">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button class="btn" data-target="#edit<?php echo $inventory['NO']; ?>"
                                                data-toggle="modal" type="button">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="btn" data-target="#delete<?php echo $inventory['NO']; ?>"
                                                data-toggle="modal" type="button">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>

                        </table>

                        <!-- pagination -->
                        <nav>
                            <ul class="pagination justify-content-center">
                                <!--        <li class="page-item">-->
                                <!--            <a class="page-link py-2 px-3" href="db_staff_inventory.php?page=--><?php
                                //            if ($page == 1) {
                                //                echo 1;
                                //            } else {
                                //                echo $page - 1;
                                //            }
                                //            ?><!--">-->
                                <!--                <span>Previous</span>-->
                                <!--            </a>-->
                                <!--        </li>-->

                                <?php for ($x = 1; $x <= $totalPage; $x++) : ?>
                                    <li class="page-item <?php
                                    if ($page == $x) {
                                        echo 'active';
                                    }
                                    ?>">
                                        <a class="page-link py-2 px-3" href="db_staff_inventory.php?page=<?php
                                        echo $x;
                                        ?>">
                                            <?php echo $x; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!--        <li class="page-item">-->
                                <!--            <a class="page-link py-2 px-3" href="db_staff_inventory.php?page=--><?php
                                //            if ($page == $totalPage) {
                                //                echo $totalPage;
                                //            } else {
                                //                echo $page + 1;
                                //            }
                                //            ?><!--">-->
                                <!--                <span>Next</span>-->
                                <!--            </a>-->
                                <!--        </li>-->
                            </ul>
                        </nav>
                        <!-- end of pagination -->

                    </div>



                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of tables -->



<!-- footer starts-->
<footer>
    <div class="container-fluid  mt-5">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row border-top pt-3">
                    <div class="col text-center">
                        <p>&copy; 2019 Copyright All rights reserved - HealthInsider</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end of footer -->

<script src="js/staffInventory.js"></script>
<script src="js\db_index.js"></script>
<script crossorigin="anonymous" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js">
</script>
<script crossorigin="anonymous" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
</script>
<script crossorigin="anonymous" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
</script>
</body>

</html>
