$('#transactionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var asset = button.data('asset');// Extract info from data-* attributes
    var asset_id = button.data('asset_id');
    var asset_amount = button.data('asset_amount');
    var cost = button.data('cost');
    var transaction_id = button.data('transaction_id');
    var inv_value = button.data('inv-val');
    
    // Update the modal's content.
    var modal = $(this)
    modal.find('.modal-form-action').attr('action', 'transaction/' + transaction_id + '/edit');
    modal.find('.hidden-id').val(transaction_id);
    modal.find('.modal-title').text('Updating Transaction of ' + asset);
    modal.find('.modal-asset-name').text(asset);
    modal.find('.modal-asset-name').attr('value', asset);
    modal.find('.modal-dropdown').val(asset_id);
    modal.find('.modal-asset-amount').val(asset_amount);
    modal.find('.modal-cost').val(cost);
    modal.find('.modal-inv-value').val(inv_value);
    

})