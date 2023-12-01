<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            height: 100vh;
        }
        .profile{
            background-color:green;
        }
    </style>
</head>
<body>

<?php
include "./navbar.php";
?>

<div class="container-fluid h-100 mt-5">
    <div class="row h-100">
    <div class="col-md-8">
            <!-- Left Column -->
            <div class="h-100 d-flex justify-content-center  bg-light">
                
                <div id="updatesContainer"></div>
            </div>
    </div>

        <div class="col-md-4">
            <!-- Right Column -->
            <div class="h-100 d-flex justify-content-center bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-11 mt-5">
                            <!-- Post Form -->
                            <form id="updateForm" onsubmit="return validatePostContent();">
                                <div class="mb-3">
                                    <label for="postContent" class="form-label">Post a new update:</label>
                                    <textarea class="form-control" id="postContent" name="postContent" rows="5" cols="20"></textarea>
                                </div>

                                <button type="button" class="btn btn-primary" onclick="submitUpdate()">Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

$(document).ready(function() {
        loadUpdates();
    });

    function loadUpdates() {
        $.ajax({
            type: "GET",
            url: "./get_updates.php", 
            success: function(response) {
                $("#updatesContainer").html(response);
            },
            error: function() {
                alert("Error loading updates!");
            }
        });
    }

    function validatePostContent() {
        var postContent = $("#postContent").val();

        // Check if postContent length is within 1 to 200 characters
        if (postContent.length < 1 || postContent.length > 200) {
            alert("Post content should be between 1 and 200 characters.");
            return false;
        }

        // Check if postContent contains only letters and numbers
        if (!/^[a-zA-Z0-9\s,.?!]*$/.test(postContent)) {
            alert("Post content should only contain letters and numbers.");
            return false;
        }

        return true;
    }

    function submitUpdate() {
        if (validatePostContent()) {
            // Get form data
            var formData = $("#updateForm").serialize();

            // Send AJAX request
            $.ajax({
                type: "POST",
                url: "./store_update.php",
                data: formData,
                success: function(response) {
                    alert("Update stored successfully.");
                    $("#postContent").val('');
                    loadUpdates();
                },
                error: function() {
                    alert("Error submitting update!");
                }
            });
        }
    }
</script>
</body>
</html>
