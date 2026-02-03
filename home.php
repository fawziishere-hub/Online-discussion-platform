<?php
// This is your existing PHP code at the top of the page (unchanged)
?>
<style>
    body {
        background-image: url("wap1.png");
    }

    #search-field .form-control.rounded-pill {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        border-right: none !important
    }

    #search-field .form-control:focus {
        box-shadow: none !important;
    }

    #search-field .form-control:focus+.input-group-append .input-group-text {
        border-color: #86b7fe !important
    }

    #search-field .input-group-text.rounded-pill {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-right: left !important
    }

    .post-item {
        /* margin-left: 20px; */
        transition: all .2s ease-in-out;
    }

    .post-item:hover {
        transform: scale(1.02);
    }

    .post-item .card {
        min-height: 180px;
        border-radius: 20px;

    }

    .post-item .card-body {
        display: flex;
        flex-direction: column;

    }

    .post-item .card-text {
        flex-grow: 1;
    }
</style>
<section class="py-3">
    <div class="container">
        <div class="se-img">
            <div>
                <img backrsrc="wap1.png" alt="">
            </div>
            <div class="row justify-content-center mb-4">
                <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                    <div class="input-group input-group-lg" id="search-field">
                        <input type="search" class="form-control form-control-lg  rounded-pill"
                            aria-label="Search Post Input" id="search" placeholder="Search">
                        <div class="input-group-append">
                            <span class="input-group-text rounded-pill bg-transparent"><i
                                    class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-1 gx-2 gy-2">
            <?php
            $posts = $conn->query("SELECT p.*, c.name as `category`, u.username FROM `post_list` p INNER JOIN category_list c ON p.category_id = c.id INNER JOIN users u ON p.user_id = u.id WHERE p.status = 1 AND p.`delete_flag` = 0 ORDER BY abs(unix_timestamp(p.date_created)) DESC");
            while ($row = $posts->fetch_assoc()):
                ?>
                <div class="col post-item">
                    <a href="./?p=posts/view_post&id=<?= $row['id'] ?>"
                        class="card rounded-20 shadow text-decoration-none text-reset h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2 text-end">
                                <small class="badge badge-secondary  text-light rounded-pill px-3"><i class="far "></i>
                                    <?= $row['category'] ?></small>
                            </div>
                            <h3 class="card-title w-100 font-weight-bold"><?= $row['title'] ?></h3>
                            <div class="card-text truncate-3 text-muted text-sm flex-grow-1">
                                <?= strip_tags($row['content']) ?>
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i>by <span
                                                class="username"><?= $row['username'] ?></span></i></small>
                                    <small
                                        class="text-muted"><i><?= date("Y-m-d h:i A", strtotime($row['date_created'])) ?></i></small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<script>
    $(function () {
        $('#search').on('input', function () {
            var _search = $(this).val().toLowerCase()
            $('.post-item').each(function () {
                var _text = $(this).text().toLowerCase()
                _text = _text.trim()
                if (_text.includes(_search) === false) {
                    $(this).toggle(false)
                } else {
                    $(this).toggle(true)
                }
            })
        })
    })
</script>