<div class="modal fade" id="phoneModalDestroy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">This number will be deleted!<br>Are You Sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form id="phoneForm" action="{{ url(config('app.url')) }}/api/v1/contact" name="phoneForm">
                    <input type="hidden" name="label" id="label">
                    <input type="hidden" name="number" id="number">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="contactid" id="contactid">
                    <input type="hidden" name="key" id="key">
                    <input type="hidden" name="method" id="method">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="phoneModalDestroySubmit" value="Submit">OK</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>