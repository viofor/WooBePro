<div class="modal fade" id="changeprofilepic" tabindex="-1" role="dialog" aria-labelledby="changeprofilepicLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change profile image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="pictureupload" enctype="multipart/form-data">
           @csrf
          <input type="file" name="picture">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button id="upload" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>