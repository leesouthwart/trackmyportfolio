<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="" class="modal-form-action" method="post">
          @csrf
          <input type="hidden" name="id" class="hidden-id" value="">
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}"
            <div class="form-group">
              <div class="row">
                <div class="col-12 col-md-6">
                  <label for="recipient-name" class="col-form-label">Asset:</label>
                  <select type="number" name="asset_id" class="modal-dropdown">
                    @foreach($assets as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-12 col-md-6">
                  <label for="recipient-name" class="col-form-label">Cost Basis:</label>
                  <input type="text" name="cost" class="modal-cost">
                </div>

                <div class="col-12 col-md-6">
                  <label for="recipient-name" class="col-form-label">Investment Value:</label>
                  <input type="text" name="value" class="modal-inv-value">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        
      </div>
    </div>
</div>