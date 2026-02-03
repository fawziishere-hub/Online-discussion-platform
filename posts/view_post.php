    <?php 
    if(isset($_GET['id'])){
        $qry = $conn->query("SELECT p.*, u.username, u.avatar, c.name as category FROM post_list p 
            INNER JOIN category_list c ON p.category_id = c.id 
            INNER JOIN users u ON p.user_id = u.id 
            WHERE p.id= '{$_GET['id']}'");
        if($qry->num_rows > 0){
            foreach($qry->fetch_array() as $k => $v){
                if(!is_numeric($k)){
                    $$k = $v;
                }
            }
        }else{
            echo '<script> alert("Post ID is not recognized."); location.replace("./?p=posts");</script>';
        }
    }else{
        echo '<script> alert("Post ID is required."); location.replace("./?p=posts");</script>';
    }

    $highest_round_query = $conn->query("SELECT MAX(round_number) as highest_round FROM debate_rounds WHERE post_id = '{$id}'");
    $highest_round = $highest_round_query->fetch_assoc()['highest_round'] ?? 0;
    $round_limit = isset($_GET['round_limit']) ? (int)$_GET['round_limit'] : 0; // Default to unlimited if not set
    if ($round_limit > 0 && $highest_round >= $round_limit) {
        echo "<p class='text-muted'><strong>The debate has reached the round limit of {$round_limit}.</strong></p>";
        $is_turn = false; // Disable further submissions
    }

    ?>
    <style>
        .post-user, .comment-user{
            width: 1.8em;
            height: 1.8em;
            object-fit:cover;
            object-position:center center;
        }
    </style>
    <div class="section py-5">
        <div class="container">
            <div class="card rounded-0 shadow">
                <div class="card-header">
                    <h4 class="card-title">Post Details</h4>
                    <?php if($_settings->userdata('id') == $user_id): ?>
                        <div class="card-tools">
                            <a href="./?p=posts/manage_post&id=<?= $id ?>" class="btn btn-sm btn-flat bg-gradient-primary btn-primary">
                                <i class="fa fa-edit"></i> Edit Post
                            </a>
                            <button type="button" id="delete_post" class="btn btn-sm btn-flat bg-gradient-danger btn-danger">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="contrain-fluid">
                        <div class="mb-2 text-right">
                            <small class="badge badge-light border text-dark rounded-pill px-3">
                                <?= $status == 1 ? '<i class="fa fa-circle text-primary"></i> Published' : '<i class="fa fa-circle text-secondary"></i> Unpublished'; ?>
                            </small>
                        </div>
                        <div class="mb-3">
                            <h2 class="font-weight-bold mb-0 border-bottom"><?= $title ?></h2>
                            <div class="py-1">
                                <small class="badge badge-light border text-dark rounded-pill px-3 me-2">
                                    <i class="far fa-circle"></i> <?= $category ?>
                                </small>
                                <span class="me-2">
                                    <img src="<?= validate_image($avatar) ?>" alt="" class="img-thumbnail border border-dark post-user rounded-circle p-0">
                                </span>
                                <span><?= $username ?></span>
                            </div>
                        </div>
                        <div><?= $content ?></div>
                        <hr class="mx-n3">
                        <h4 class="font-weight-bolder">Live Debate</h4>
                        <div id="debate-details">
                            <p><strong>Debate Creator:</strong> <?= $username ?></p>
                            <p><strong>First Participant:</strong> 
                                <?php  
                                    $participant_query = $conn->query("SELECT u.username FROM debate_rounds d 
                                        INNER JOIN users u ON d.user_id = u.id 
                                        WHERE d.post_id = '{$id}' ORDER BY d.date_created ASC LIMIT 1");
                                    $participant_two = $participant_query->num_rows > 0 ? $participant_query->fetch_assoc()['username'] : 'Waiting for first joiner...';
                                    echo $participant_two;
                                ?>
                            </p>
                        </div>

                        <div class="debate-content mt-3">
        <h5>Debate Rounds:</h5>
        <?php 
    $rounds = $conn->query("SELECT d.round_number, d.content, u.username, d.user_id FROM debate_rounds d 
                            INNER JOIN users u ON d.user_id = u.id 
                            WHERE d.post_id = '{$id}' ORDER BY d.round_number ASC");
$last_user_id = null;
$last_round_number = 0;
while ($round = $rounds->fetch_assoc()):
    $current_round = ceil($round['round_number'] / 2); // Group both participants under the same round number
    if ($current_round != $last_round_number) {
        echo "<h5 class='text-muted'>Round {$current_round}</h5>";
        $last_round_number = $current_round;
    }
?>
    <div class="mb-3">
        <p><strong>(<?= $round['username'] ?>):</strong> <?= $round['content'] ?></p>
    </div>
<?php
    $last_user_id = $round['user_id'];
endwhile;


    // Determine the next turn
    $creator_id = $user_id;
    $current_user_id = $_settings->userdata('id');
    $is_turn = false;

    // Check if it's the participant's first turn
    if ($last_user_id === null) {
        $is_turn = ($current_user_id != $creator_id);
    } else {
        $is_turn = ($last_user_id != $current_user_id);
    }





        // Determine participants
        $creator_id = $user_id; // Post creator's ID
        $current_user_id = $_settings->userdata('id');
        $is_turn = false;

        // Fetch first participant
        $participant_query = $conn->query("SELECT u.id, u.username FROM debate_rounds d 
                                        INNER JOIN users u ON d.user_id = u.id 
                                        WHERE d.post_id = '{$id}' ORDER BY d.date_created ASC LIMIT 1");
        $participant = $participant_query->fetch_assoc();
        $participant_id = $participant['id'] ?? null;

        // If no participant yet, and the current user is not the creator, set them as the first participant
        if (!$participant_id && $current_user_id != $creator_id) {
            $participant_id = $current_user_id;
        }

        // Enforce turn-based debate logic
        if ($last_user_id === null) {
            // First round: Only the participant can submit
            $is_turn = ($current_user_id == $participant_id);
        } else {
            // Alternate turns
            $is_turn = ($last_user_id != $current_user_id);
        }

        // Check if the current user is a valid participant
        $is_valid_participant = ($current_user_id == $creator_id || $current_user_id == $participant_id);
        ?>

<?php if ($is_valid_participant && $is_turn && ($round_limit == 0 || $highest_round < $round_limit)): ?>
    <form action="" id="debate-form">
        <input type="hidden" name="post_id" value="<?= $id ?>">
        <textarea class="form-control form-control-sm rounded-0" name="content" id="content" rows="4" placeholder="Enter your argument"></textarea>
        <button class="btn btn-primary mt-2" form="debate-form">Submit Argument</button>
    </form>
<?php elseif ($round_limit > 0 && $highest_round >= $round_limit): ?>
    <p class="text-muted">The debate has reached the maximum number of rounds.</p>
<?php elseif ($is_valid_participant): ?>
    <p class="text-muted">It's not your turn to submit an argument.</p>
<?php else: ?>
    <p class="text-muted">You can only comment as a viewer.</p>
<?php endif; ?>


    </div>



    <?php if (!($current_user_id == $creator_id || $current_user_id == $participant_id)): ?>
        
    
    <?php endif; ?>

            

    </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
                    
                </div>
                <div class="card-body">
                    <div class="contrain-fluid">
                        <?php if($_settings->userdata('id') == $user_id): ?>
                        <div class="mb-2 text-right">
                            <?php if($status == 1): ?>
                                <small class="badge badge-light border text-dark rounded-pill px-3"><i class="fa fa-circle text-primary"></i> Published</small>
                            <?php else: ?>
                                <small class="badge badge-light border text-dark rounded-pill px-3"><i class="fa fa-circle text-secondary"></i> Unpublished</small>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <div style="line-height:1em" class="mb-3">
                            <h2 class="font-weight-bold mb-0 border-bottom"><?= $title ?></h2>
                            <div class="py-1">
                                <small class="badge badge-light border text-dark rounded-pill px-3 me-2"><i class="far fa-circle"></i> <?= $category ?></small>
                                <span class="me-2"><img src="<?= validate_image($avatar) ?>" alt="" class="img-thumbnail border border-dark post-user rounded-circle p-0"></span>
                                <span class=""><?= $username ?></span>
                            </div>
                        </div>
                        <div>
                            <?= $content ?>
                        </div>
                        <hr class="mx-n3">
                        <h4 class="font-weight-bolder">Comments:</h4>
                        <div class="list-group comment-list mb-3 rounded-0">
                            <?php 
                            $comments = $conn->query("SELECT c.*, u.username, u.avatar FROM `comment_list` c inner join `users` u on c.user_id = u.id where c.post_id ='{$id}' order by abs(unix_timestamp(c.date_created)) asc ");
                            while($row = $comments->fetch_assoc()):
                            ?>
                            <div class="list-group-item list-group-item-action mb-1 border-top">
                                <div class="d-flex align-items-center w-100">
                                    <div class="col-auto">
                                        <img src="<?= validate_image($row['avatar']) ?>" alt="" class="comment-user rounded-circle img-thumbnail p-0 border">
                                    </div>
                                    <div class="col-auto flex-shrink-1 flex-grow-1">
                                        <div style="line-height:1em">
                                            <div class="font-weight-bolder"><?= $row['username'] ?></div>
                                            <div><small class="text-muted"><i><?= date("Y-m-d h:i a", strtotime($row['date_created'])) ?></i></small></div>
                                        </div>
                                    </div>
                                    <?php if($row['user_id'] == $_settings->userdata('id')): ?>
                                        <a href="javascript:void(0)" class="text-danger text-decoration-none delete-comment" data-id = '<?= $row['id'] ?>'><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                                <hr>
                                <div><?= $row['comment'] ?></div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        <?php if ($_settings->userdata('id') == ''): ?>
    <h5 class="text-center text-muted"><i>Login to Post a Comment</i></h5>
<?php else: ?>
    <div class="card rounded-0 shadow">
        <div class="card-body">
            <div class="container-fluid">
                <form action="" id="comment-form">
                    <input type="hidden" name="post_id" value="<?= $id ?>">
                    <textarea class="form-control form-control-sm rounded-0" name="comment" id="comment" rows="4" placeholder="Write your comment here"></textarea>
                </form>
            </div>
        </div>
        <div class="card-footer py-1 text-right">
            <button class="btn btn-primary btn-flat btn-sm bg-gradient-primary" form="comment-form"><i class="fa fa-save"></i> Save</button>
            <button class="btn btn-light btn-flat btn-sm bg-gradient-light border" type="reset" form="comment-form">Cancel</button>
        </div>
    </div>
<?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    $('#join-debate').click(function () {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=join_debate",
            method: "POST",
            data: { post_id: <?= $id ?> },
            dataType: "json",
            success: function (resp) {
                if (resp.status === 'success') {
                    alert("You have joined the debate. You can now submit your argument.");
                    location.reload(); // Reload to reflect the participant's ability to submit
                } else {
                    alert(resp.msg || "Failed to join the debate.");
                }
                end_loader();
            },
            error: function (err) {
                alert("An error occurred. Check the console for more details.");
                console.log(err);
                end_loader();
            }
        });
    });



        $('#debate-form').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var content = $('#content').val();
        var post_id = $('input[name="post_id"]').val();

        if (!content.trim()) {
            alert("Content cannot be empty.");
            return false;
        }

        start_loader();

        $.ajax({
            url: _base_url_ + "classes/Master.php?f=submit_argument",
            method: "POST",
            data: new FormData(form[0]),
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(resp) {
                if (resp.status === 'success') {
                    alert("Argument submitted successfully!");
                    location.reload();
                } else {
                    alert(resp.msg || "Failed to submit argument.");
                }
                end_loader();
            },
            error: function(err) {
                alert("An error occurred. Check the console for more details.");
                console.log(err);
                end_loader();
            }
        });
    });



    </script>

    <script>
        $(function(){
            $('.delete-comment').click(function(){
                _conf("Are your sure to delete this comment?", "delete_comment", [$(this).attr('data-id')])
            })
            $('#delete_post').click(function(){
                _conf("Are your sure to delete this post?", "delete_post", ['<?= isset($id) ? $id : '' ?>'])
            })
            $('#comment').summernote({
                height:"15em",
                placeholder:"Write your comment here",
                toolbar: [
                    [ 'style', [ 'style' ] ],
                    [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                    [ 'fontname', [ 'fontname' ] ],
                    [ 'fontsize', [ 'fontsize' ] ],
                    [ 'color', [ 'color' ] ],
                    [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                    [ 'table', [ 'table' ] ],
                    [ 'view', [ 'codeview'] ]
                ]
            })

    
        



            $('#comment-form').submit(function(e){
                e.preventDefault()
                var _this = $(this)
                var el = $('<div>')
                    el.addClass('alert alert-danger err_msg')
                    el.hide()
                $('.err_msg').remove()
                if(_this[0].checkValidity() == false){
                    _this[0].reportValidity();
                    return false;
                }
                start_loader()
                $.ajax({
                    url:_base_url_+"classes/Master.php?f=save_comment",
                    method:'POST',
                    type:'POST',
                    data:new FormData($(this)[0]),
                    dataType:'json',
                    cache:false,
                    processData:false,
                    contentType: false,
                    error:err=>{
                        console.log(err)
                        alert('An error occurred')
                        end_loader()
                    },
                    success:function(resp){
                        if(resp.status == 'success'){
                        location.reload()
                        }else if(!!resp.msg){
                            el.html(resp.msg)
                            el.show('slow')
                            _this.prepend(el)
                            $('html, body').scrollTop(_this.offset().top + 15)
                        }else{
                            alert('An error occurred')
                            console.log(resp)
                        }
                        end_loader()
                    }
                })
            })
        })
        function delete_post($id){
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=delete_post",
                method:"POST",
                data:{id: $id},
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured.",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp== 'object' && resp.status == 'success'){
                        location.replace('./?p=posts');
                    }else{
                        alert_toast("An error occured.",'error');
                        end_loader();
                    }
                }
            })
        }
        
        function delete_comment($id){
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=delete_comment",
                method:"POST",
                data:{id: $id},
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured.",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp== 'object' && resp.status == 'success'){
                        location.reload();
                    }else{
                        alert_toast("An error occured.",'error');
                        end_loader();
                    }
                }
            })
        }
        
    </script>