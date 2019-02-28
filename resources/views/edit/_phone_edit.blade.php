<div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Phone Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="phoneForm" action="{{ url(config('app.url')) }}/api/v1/contact" name="phoneForm">
                    <div class="form-group">
                        <label for="label" class="col-form-label">Label:</label>
                        <input type="text" class="form-control" id="label">
                    </div>
                    <div class="form-group">
                        <label for="number" class="col-form-label">Number:</label>
                        <input class="form-control" id="number">
                    </div>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="contactid" id="contactid">
                    <input type="hidden" name="key" id="key">
                    <input type="hidden" name="method" id="method">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="phoneModalSubmit" value="Submit">Submit</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>