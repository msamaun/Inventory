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
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label">Product Description *</label>
                                <input type="text" class="form-control" id="productDescriptionUpdate">

                                <label class="form-label">Product Category *</label>
                                <select type="text" class="form-control" id="productCategoryUpdate">
                                    <option value="">Select Category </option>
                                </select>

                                <label class="form-label">Product Unit Price *</label>
                                <input type="text" class="form-control" id="productUnitPriceUpdate">

                                <label class="form-label">Product Quantity *</label>
                                <input type="text" class="form-control" id="productQuantityUpdate">

                                <br/>
                                <img class="w-15" id="oldLmg" src="{{asset('images/default.jpg')}}">
                                <br/>

                                <label class="form-label">Product Image *</label>
                                <input oninput="oldLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImageUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="oldImage">
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
   async function UpdateFillCategoryDropdown(){
      let res =await axios.get("/list-category",HeaderToken())
      res.data['data'].forEach(function (item) {
          let option = `<option value="${item['id']}">${item['name']}</option>`
          $("#productCategoryUpdate").append(option);
      })
   }
   async function FillUpUpdateForm(id,filePath){
       document.getElementById("updateID").value = id;
       document.getElementById("oldImage").value = filePath;
       document.getElementById("oldLmg").src = filePath;

       showLoader();
       await UpdateFillCategoryDropdown();
       const response = await axios.post("/product-by-id",{id:id},HeaderToken());
       hideLoader();

       document.getElementById("productNameUpdate").value =response.data['data']['name'];
       document.getElementById("productDescriptionUpdate").value =response.data['data']['description'];
       document.getElementById("productCategoryUpdate").value =response.data['data']['category_id'];
       document.getElementById("productUnitPriceUpdate").value =response.data['data']['unit_price'];
       document.getElementById("productQuantityUpdate").value =response.data['data']['quantity'];

   }

   async function Update()
   {
       let productNameUpdate=document.getElementById('productNameUpdate').value
       let productDescriptionUpdate=document.getElementById('productDescriptionUpdate').value
       let productCategoryUpdate=document.getElementById('productCategoryUpdate').value
       let productUnitPriceUpdate=document.getElementById('productUnitPriceUpdate').value
       let productQuantityUpdate=document.getElementById('productQuantityUpdate').value
       let productImageUpdate=document.getElementById('productImageUpdate').value

       let oldLmg=document.getElementById('updateID').value
       let oldImage=document.getElementById('oldImage').value


           document.getElementById('update-modal-close').click();

           let formData = new FormData();
           formData.append('name',productNameUpdate)
           formData.append('description',productDescriptionUpdate)
           formData.append('category_id',productCategoryUpdate)
           formData.append('unit_price',productUnitPriceUpdate)
           formData.append('quantity',productQuantityUpdate)
           formData.append('image',productImageUpdate)
           formData.append('id',oldLmg)
           formData.append('file_path',oldImage)




           const config = {
               headers: {
                   'content-type': 'multipart/form-data',
                   Authorization:getToken()
               }
           }
           showLoader();
           let res = await axios.post("/product-update",formData,config)
           hideLoader();

           if (res.status === 200 && res.data === 1) {
               successToast("Product Update Successfully");
               document.getElementById('update-form').reset();
               await getList();
           }
           else {
               errorToast("Failed To Update Product");
           }

   }
</script>


