<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Font Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" -->
    <!-- integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->
</head>

<body>
    <div class="container">
        <div class="alert alert alert-primary" role="alert">
            <h4 class="text-primary text-center">Font Management</h4>
        </div>
        <div class="alert alert-success text-center message" role="alert">

        </div>
        <?php
?>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8 mb-3">
                <form id="addfont" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12 image-upload position-relative overflow-hidden">
                        <input type="file" id="font_file" onchange="fileValuesTwo(this)">
                        <input type="hidden" name="action" id="action" value="addfont">
                        <input type="hidden" id="imgbback">
                        <label for="font_file" class="upload-field mb-0" id="file-label">
                            <span class="file-thumbnail">
                                <img id="file-preview" style="height:40px;" src="assets/uploads/upload.png" alt="">
                                <span id="file-name2" class="d-block mt-2">Click to upload or drag and drop</span>
                                <span class="format">Only TTF File Allowed</span>
                            </span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <?php
include_once 'views/fontlist.php';
?>
        <nav id="pagination">
        </nav>
        <input type="hidden" name="base_url" id="base_url"
            value="<?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">
        <div class="row mb-3">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <form id="add_font_group" method="POST">
                    <h4>Create Font Group </h4>
                    <p>You have to create at least two fonts </p>
                    <div class="form-group">
                        <!-- <label for="formGroupExampleInput">Example label</label> -->
                        <input type="text" class="form-control" required name="group_title" id="group_title"
                            placeholder="Group Title">
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font_group">
                            <div class="row list_1">
                                <div class="col">
                                    <input type="text" class="form-control" required name="font_name[]" id="font_name_1"
                                        placeholder="Font name">
                                </div>
                                <div class="col">
                                    <select class="custom-select" required name="font_list[]" id="font_list_1">

                                    </select>
                                </div>
                                <button type="button" onclick="del_row(1)" class="close" aria-label="Close">
                                    <span aria-hidden="true" class="text-danger">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="add_row()" class="btn btn-light"><i class="fa fa-plus mr-1"
                            aria-hidden="true"></i>Add Row</button>
                    <button type="submit" class="btn btn-success float-right">Create</button>
                    <input type="hidden" name="action" value="add_font_group">
                    <input type="hidden" name="font_group_id" id="font_group_id" value="">
                </form>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <?php
include_once 'views/fontgrouplist.php';
?>
    </div>
    <select hidden class="custom-select" id="font_list_0">

    </select>
    <div>

        <!-- JS, Popper.js, and jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="assets/js/script.js"></script>
    </div>
    <div id="overlay" style="display:none;">
        <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
        <br />
        Loading...
    </div>
</body>

</html>