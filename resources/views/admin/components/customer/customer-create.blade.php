<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Category</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer First Name *</label>
                                <input type="text" class="form-control" id="customerFirstName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Last Name *</label>
                                <input type="text" class="form-control" id="customerLastName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Email *</label>
                                <input type="email" class="form-control" id="customerEmail">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Phone *</label>
                                <input type="text" class="form-control" id="customerPhone">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Address *</label>
                                <input type="text" class="form-control" id="customerAddress">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    async function Save() {
        try {
            let customerFirstName = document.getElementById('customerFirstName').value;
            let customerLastName = document.getElementById('customerLastName').value;
            let customerEmail = document.getElementById('customerEmail').value;
            let customerPhone = document.getElementById('customerPhone').value;
            let customerAddress = document.getElementById('customerAddress').value;

            document.getElementById('modal-close').click();
            showLoader();
            let res = await axios.post('/customer-create',{firstName:customerFirstName,lastName:customerLastName,email:customerEmail,phone:customerPhone,address:customerAddress},HeaderToken());
            hideLoader();

            if(res.data['status']==="success"){
                successToast(res.data['message']);
                document.getElementById('save-form').reset();
                await getList();
            }
        }
        catch (e) {
            unauthorized(e)
        }
    }
</script>
