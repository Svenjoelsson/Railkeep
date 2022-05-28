


<button type="button" class="btn btn-primary" style="float:right;" data-toggle="modal"
data-target="#newComment">
    New comment
</button><br /><br />
<?php
    $comments = \App\Models\Comments::where('model_id', Request::segment(2))->where('model_type', Request::segment(1))->orderBy('created_at', 'desc')->get();
    foreach ($comments as $comment) { ?>

        <div class="card shadow">
            <div class="card-header activeNav">
                <span style="float:left;">{{ $comment->created_by }}</span>
                <span style="float:right;">{{ $comment->created_at }}</span>
            </div>
            <div class="card-body">
            <p class="card-text"><?php echo nl2br($comment->comment) ?></p>
            </div>
        </div>

<?php } ?>










<div class="modal fade" id="newComment" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New comment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{url('comments/new')}}" accept-charset="UTF-8">
            <input type="hidden" name="model_type" value="{{ Request::segment(1) }}">
            <input type="hidden" name="model_id" value="{{ Request::segment(2) }}">
            
            @csrf <!-- {{ csrf_field() }} -->

            <label for="date">Comment</label>
            <textarea name="comment" rows="5" class="form-control"></textarea>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
        </div>
    </div>
</div>
</div>