<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `post_list` where id= '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_array() as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    }
}
?>

<style>
    .form-group.note-form-group.note-group-select-from-files {
        display: none;
    }

    .card {
        background: #ffffff;
        color: #222831;
        font-family: 'Arial', sans-serif;
        border: none;
        border-radius: 20px;

    }

    .card-body {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        padding: 20px 30px;
    }



    #title {
        background-color: rgb(240, 238, 238);
        color: #222831;
        border: none;
    }


    #category_id {
        background-color: #222831;
        color: #DDDDDD;
        border: none;
        border-radius: 20px;
    }



    .btn-primary {
        background-color: #F05454;
        border: none;
        width: 90px;
        border-radius: 20px;
        padding: 10px;
        font-size: 1em;
    }

    .btn-primary:hover {
        background-color: rgb(48, 71, 94);
    }

    .btn-secondary {
        background-color: #222831;
        border: none;
        width: 90px;
        border-radius: 20px;
        padding: 10px;
        font-size: 1em;
    }

    .btn-secondary:hover {
        background-color: #DDDDDD;
    }

    .form-check-input:checked {
        background-color: #F05454;
    }
</style>
<section class="py-4">
    <div class="container">
        <div class="card rounded-20 card-gray ">
            <div class="card-header">
                <h5 class="card-title"><?= !isset($id) ? "Add New Topic" : "Update Topic Details" ?></h5>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="post-form">
                        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                        <div class="form-group">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" class="form-control rounded-20" name="title" id="title"
                                value="<?= isset($title) ? $title : "" ?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 px-0">
                            <label for="category_id" class="control-label">Category</label>
                            <select class="form-control rounded-20" name="category_id" id="category_id">
                                <option value="" disabled <?= !isset($category_id) ? "selected" : '' ?>></option>
                                <?php
                                $category = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1 " . (isset($category_id) && $category_id > 0 ? " or id = '{$category_id}' " : "") . "  order by `name` asc");
                                while ($row = $category->fetch_array()):
                                    ?>
                                    <option value="<?= $row['id'] ?>" <?= isset($category_id) && $category_id == $row['id'] ? "selected" : "" ?>><?= $row['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content" class="control-label">Content</label>
                            <textarea type="text" class="form-control rounded-20" name="content"
                                id="content"><?= isset($content) ? $content : "" ?></textarea>
                        </div>
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="status" name='status' value="1" <?= isset($status) && $status == 1 ? 'checked' : '' ?>>
                                <label for="status">
                                </label>
                            </div>
                            <label for="status" class="control-label">Published</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer py-1 text-center">
                <button class="btn  btn-sm btn-primary " form="post-form"><i class="fa fa-save"></i> Save</button>
                <a class="btn  btn-sm btn-secondary " href="./?p=posts"><i class="fa fa-angle-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('#category_id').select2({
            placeholder: "Please Select Category Here",
            width: '100%',
            containerCssClass: 'form-control rounded-20'
        })
        $('#content').summernote({
            height: "20em",
            placeholder: "Write your content here",
            toolbar: [
                // ['style', ['style']],
                // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                // ['fontname', ['fontname']],
                // ['fontsize', ['fontsize']],
                // ['color', ['color']],
                // ['para', ['ol', 'ul', 'paragraph', 'height']],
                // ['table', ['table']],
                // ['insert', ['picture']],
                // ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        })
        $('#post-form').submit(function (e) {
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
                url: _base_url_ + "classes/Master.php?f=save_post",
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
                        location.replace('./?page=posts/view_post&id=' + resp.pid)
                    } else if (!!resp.msg) {
                        el.html(resp.msg)
                        el.show('slow')
                        _this.prepend(el)
                        $('html, body').scrollTop(0)
                    } else {
                        alert('An error occurred')
                        console.log(resp)
                    }
                    end_loader()
                }
            })
        })
    })
</script>