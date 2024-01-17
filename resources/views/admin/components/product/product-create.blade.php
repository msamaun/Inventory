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
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label">Product Description *</label>
                                <input type="text" class="form-control" id="productDescription">

                                <label class="form-label">Product Category *</label>
                                <select type="text" class="form-control" id="productCategory">
                                    <option value="">Select Category </option>
                                </select>

                                <label class="form-label">Product Unit Price *</label>
                                <input type="text" class="form-control" id="productUnitPrice">

                                <label class="form-label">Product Quantity *</label>
                                <input type="text" class="form-control" id="productQuantity">

                            <br/>
                                <img class="w-15" id="newLmg" src="{{asset('images/default.jpg')}}">
                             <br/>

                                <label class="form-label">Product Image *</label>
                                <input oninput="newLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImage">

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
    FillCategoryDropdown();

    async function FillCategoryDropdown(){
        let res =await axios.get("/list-category",HeaderToken())

        res.data['data'].forEach((item)=>{
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productCategory").append(option);
        })

    }
    async function Save() {
        try{
            let productName=document.getElementById('productName').value
            let productDescription=document.getElementById('productDescription').value
            let productCategory=document.getElementById('productCategory').value
            let productUnitPrice=document.getElementById('productUnitPrice').value
            let productQuantity=document.getElementById('productQuantity').value
            let productImage=document.getElementById('productImage').files[0]

            document.getElementById('modal-close').click();




           let formData = new FormData();
           formData.append('name',productName)
           formData.append('description',productDescription)
           formData.append('category_id',productCategory)
           formData.append('unit_price',productUnitPrice)
           formData.append('quantity',productQuantity)
           formData.append('image',productImage)


            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization:getToken()
                }
            }


            showLoader();
            let res = await axios.post("/product-create",formData,config);
            hideLoader();



            if(res.data['status']){
                console.log(res.data)
               successToast('Product created successfully');
               document.getElementById('save-form').reset();
               await getList();
            }
            else{
                errorToast(res.data['message']);
            }
        }
        catch (e) {
            unauthorized(e)
        }
    }
</script>
