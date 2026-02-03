<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT p.*, u.username, u.avatar, c.name as `category` FROM `post_list` p inner join category_list c on p.category_id = c.id inner join `users` u on p.user_id = u.id where p.id= '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_array() as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    } else {
        echo '<script> alert("Post ID is not recognized."; location.replace("./p=posts");</script>';
    }
} else {
    echo '<script> alert("Post ID is required"; location.replace("./p=posts");</script>';

}
?>
<style>
    .post-user,
    .comment-user {
        width: 1.8em;
        height: 1.8em;
        object-fit: cover;
        object-position: center center;
    }

    hr {
        color: rgb(48, 71, 94);
    }

    .card {
        background: #ffffff;
        color: #222831;
        font-family: 'Arial', sans-serif;
        border: none;
        border-radius: 20px;

    }

    .card-body {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); */
        padding: 20px 30px;

    }

    .card-title {
        margin-top: 15px;
        background-color: #F05454;
        border-radius: 10px;
        width: 110px;
        text-align: center;

    }

    .card-footer {
        background-color: transparent;
    }

    .btn-primary {
        background-color: rgb(48, 71, 94);
        border: none;
        width: 90px;
        border-radius: 20px;
        padding: 10px;
        font-size: 1em;
    }

    .btn-primary:hover {
        background-color: #DDDDDD;
    }



    .btn-danger {
        background-color: #222831;
        border: none;
        width: 90px;
        border-radius: 20px;
        padding: 10px;
        font-size: 1em;
    }

    .btn-danger:hover {
        background-color: #DDDDDD;
    }

    .post-user,
    .comment-user {
        width: 1.8em;
        height: 1.8em;
        object-fit: cover;
        object-position: center center;
    }

    .content-area {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }



    .comment-area {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 20px;

    }

    i.fa-trash {
        color: #F05454;
    }

    div.content-area {
        background-color: #222831;
        color: #DDDDDD;
        border: none;
    }

    div.comment-area {
        background-color: #DDDDDD;
        border: none;
        border-radius: 20px;


    }

    div.list-group-item {
        background-color: #ccc;
        color: #222831;
        border: none;
        border-radius: 20px;
        padding: 10px;
        font-size: 1em;
    }

    div.list-group-item:hover {
        background-color: #DDDDDD;
        color: #222831;
    }

    .btn-light {
        background-color: #222831;
        color: #DDDDDD;
        border: none;
        width: 90px;
        border-radius: 20px;
        padding: 10px;
        font-size: 1em;
    }

    .btn-light:hover {
        background-color: #DDDDDD;
    }
</style>
<div class="card  card-gray rounded-20 ">
    <div class="card-header">
        <h4 class="card-title">Post Details</h4>
        <div class="card-tools">
            <a href="./?page=posts/manage_post&id=<?= $id ?>" class="btn btn-sm  btn-primary"><i class="fa fa-edit"></i>
                Edit Post</a>
            <button type="button" id="delete_post" class="btn btn-sm  btn-danger"><i class="fa fa-trash"></i>
                Delete</button>
        </div>
    </div>
    <div class="card-body">
        <div class="contrain-fluid">
            <?php if ($_settings->userdata('id') == $user_id): ?>
                <div class="mb-2 text-right">
                    <?php if ($status == 1): ?>
                        <small class="badge badge-light border text-dark rounded-pill px-3"><i
                                class="fa fa-circle text-primary"></i> Published</small>
                    <?php else: ?>
                        <small class="badge badge-light border text-dark rounded-pill px-3"><i
                                class="fa fa-circle text-secondary"></i> Unpublished</small>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div style="line-height:1em" class="mb-3">
                <h2 class="font-weight-bold mb-1 "><?= $title ?></h2>
                <div class="py-1">
                    <small class="badge badge-light border text-dark rounded-pill px-3 me-2"><i class="far "></i>
                        <?= $category ?></small>
                    <!-- <span class="me-2"><img src="<?= validate_image($avatar) ?>" alt=""
                            class="img-thumbnail border border-dark post-user rounded-circle p-0"></span> -->
                    <span>by</span>
                    <span class=""><?= $username ?></span>
                </div>
            </div>
            <div>
                <?= $content ?>
            </div>
            <hr class="mx-n3">
            <h4 class="font-weight-bolder">Comments:</h4>
            <div class="list-group comment-list mb-3 rounded-20">
                <?php
                $comments = $conn->query("SELECT c.*, u.username, u.avatar FROM `comment_list` c inner join `users` u on c.user_id = u.id where c.post_id ='{$id}' order by abs(unix_timestamp(c.date_created)) asc ");
                while ($row = $comments->fetch_assoc()):
                    ?>
                    <div class="list-group-item list-group-item-action mb-1 border-top">
                        <div class="d-flex align-items-center w-100">
                            <!-- <div class="col-auto">
                                <img src="<?= validate_image($row['avatar']) ?>" alt=""
                                    class="comment-user rounded-circle img-thumbnail p-0 border">
                            </div> -->
                            <div class="col-auto flex-shrink-1 flex-grow-1">
                                <div style="line-height:1em">
                                    <div class="font-weight-bolder"><?= $row['username'] ?></div>
                                    <div><small
                                            class="text-muted"><i><?= date("Y-m-d h:i a", strtotime($row['date_created'])) ?></i></small>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="text-danger text-decoration-none delete-comment"
                                data-id='<?= $row['id'] ?>'><i class="fa fa-trash"></i></a>
                        </div>
                        <hr>
                        <div><?= $row['comment'] ?></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php if ($_settings->userdata('id') == ''): ?>
                <h5 class="text-center text-muted"><i>Login to Post a Comment</i></h5>
            <?php else: ?>
                <div class="card rounded-20 ">
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="" id="comment-form">
                                <input type="hidden" name="post_id" value="<?= $id ?>">
                                <textarea class="form-control form-control-sm rouned-0" name="comment" id="comment" rows="4"
                                    placeholder="Write your comment here"></textarea>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer py-1 text-right">
                        <button class="btn btn-primary  btn-sm " form="comment-form"><i class="fa fa-save"></i>
                            Save</button>
                        <button class="btn btn-danger  btn-sm " type="reset" form="comment-form">Cancel</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.delete-comment').click(function () {
            _conf("Are your sure to delete this comment?", "delete_comment", [$(this).attr('data-id')])
        })
        $('#delete_post').click(function () {
            _conf("Are your sure to delete this post?", "delete_post", ['<?= isset($id) ? $id : '' ?>'])
        })
        $('#comment').summernote({
            height: 60,
            placeholder: "Write your comment here",
            toolbar: [
                // ['style', ['style']],
                // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                // ['fontname', ['fontname']],
                // ['fontsize', ['fontsize']],
                // ['color', ['color']],
                // ['para', ['ol', 'ul', 'paragraph', 'height']],
                // ['table', ['table']],
                // ['view', ['codeview']]
            ]
        })
        $('#comment-form').submit(function (e) {
            e.preventDefault()
            var _this = $(this)
            var el = $('<div>')
            el.addClass('alert alert-danger err_msg')
            el.hide()
            $('.err_msg').remove()
            if (_this[0].checkValidity() == false) {
                _this[0].reportValidity();
                return false;
            }
            start_loader()
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_comment",
                method: 'POST',
                type: 'POST',
                data: new FormData($(this)[0]),
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                error: err => {
                    console.log(err)
                    alert('An error occurred')
                    end_loader()
                },
                success: function (resp) {
                    if (resp.status == 'success') {
                        location.reload()
                    } else if (!!resp.msg) {
                        el.html(resp.msg)
                        el.show('slow')
                        _this.prepend(el)
                        $('html, body').scrollTop(_this.offset().top + 15)
                    } else {
                        alert('An error occurred')
                        console.log(resp)
                    }
                    end_loader()
                }
            })
        })
    })
    function delete_post($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_post",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occured.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.replace('./?page=posts');
                } else {
                    alert_toast("An error occured.", 'error');
                    end_loader();
                }
            }
        })
    }

    function delete_comment($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_comment",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occured.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occured.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>