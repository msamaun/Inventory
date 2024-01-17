<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer First Name *</label>
                                <input type="text" class="form-control" id="customerFirstNameUpdate">

                                <label class="form-label">Customer Last Name *</label>
                                <input type="text" class="form-control" id="customerLastNameUpdate">

                                <label class="form-label mt-3">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">

                                <label class="form-label mt-3">Customer Phone *</label>
                                <input type="text" class="form-control" id="customerPhoneUpdate">

                                <label class="form-label mt-3">Customer Address *</label>
                                <input type="text" class="form-control" id="customerAddressUpdate">

                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>
    async function FillUpUpdateForm(id)
    {
        try{
            document.getElementById('updateID').value = id;
            showLoader();
            let res = await axios.post('/customer-by-id',{id:id},HeaderToken());
            hideLoader();

            document.getElementById('customerFirstNameUpdate').value = res.data['data']['firstName'];
            document.getElementById('customerLastNameUpdate').value = res.data['data']['lastName'];
            document.getElementById('customerEmailUpdate').value = res.data['data']['email'];
            document.getElementById('customerPhoneUpdate').value = res.data['data']['phone'];
            document.getElementById('customerAddressUpdate').value = res.data['data']['address'];
        }
        catch(e){
            unauthorized(e);
        }
    }

    async function Update(){
        try{
            let customerFirstName = document.getElementById('customerFirstNameUpdate').value;
            let customerLastName = document.getElementById('customerLastNameUpdate').value;
            let customerEmail = document.getElementById('customerEmailUpdate').value;
            let customerPhone = document.getElementById('customerPhoneUpdate').value;
            let customerAddress = document.getElementById('customerAddressUpdate').value;

            let id = document.getElementById('updateID').value;
            document.getElementById('update-modal-close').click();

            showLoader();
            let res = await axios.post('/customer-update',{firstName: customerFirstName,lastName: customerLastName,email: customerEmail,phone: customerPhone,address: customerAddress,id:id},HeaderToken());
            hideLoader();

            if(res.data['status'] === 'success'){
                document.getElementById('update-form').reset();
            successToast(res.data['message']);
            await getList();
            }
            else{
                errorToast(res.data['message']);
            }

        }
        catch(e){
            unauthorized(e);
        }
    }
</script>
