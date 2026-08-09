
<div class="form-group col-sm-12">
    <label for="">Name<span class="text-danger"></span></label>
    <p>{{ $forum->name }}</p>
</div>

<div class="form-group col-sm-12">
    <label for="">User<span class="text-danger"></span></label>
    <p>{{ $forum?->user?->name }}</p>
</div>

<div class="form-group col-sm-12">
    <label for="">Description<span class="text-danger"></span></label>
    <p>{{ $forum->description }}</p>
</div>

<div class="form-group col-sm-12">
    <label for="">Tag<span class="text-danger"></span></label>
    <p>{{ $forum->tags }}</p>
</div>

<div class="form-group col-sm-12">
    <label for="">Likes<span class="text-danger"></span></label>
    <p>{{ $forum?->likes?->count() }}</p>
</div>

<div class="form-group col-sm-12">
    <label for="">Shares<span class="text-danger"></span></label>
    <p>{{ $forum?->shares?->count() }}</p>
</div>


