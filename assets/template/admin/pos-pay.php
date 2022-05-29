<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class=" text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mt-3">
                    <label>Total Purchase Items:</label>
                    <input type="number" class="form-control" readonly value="<?= $total_quantity; ?>">
                </div>
                <div class="mt-3">
                    <label>Total Price:</label>
                    <input type="text" class="form-control border border-danger" id="inputProductPrice"
                        value="<?=$total_price; ?>" oninput="calculateNoDiscount()" readonly>
                </div>
                <div class="mt-3">
                    <label>Amount of Pay</label>
                    <input type="number" class="form-control" id="inputPaid" name="amountPay"
                        oninput="calculateNoDiscount()" onkeyup="EnableDisable(this)" required>
                </div>
                <div class="mt-3">
                    <strong>Dicount(<i>For Senior Citizen and PWD only</i>)</strong>
                    <label>Customer Type</label>
                    <select class="form-control" id="selectedCustomer" name="selectedCustomer"
                        onchange="chooseDiscount()" disabled>
                        <option value="">Select</option>
                        <option value="PWD">PWD</option>
                        <option value="Senior Citizen">Senior Citizen</option>
                    </select>
                </div>
                <div id="discount" style="display:none;" class="mt-3">
                    <div class="mt-3">
                        <label>Discount</label>
                        <div style="display: flex; flex-direction:row">
                            <input type="text" class="form-control" id="inputDiscount" name="discount" value="20"
                                readonly onchange="chooseDiscount()">
              <span>&nbsp;%</span>
            </div>
          </div>
          <div class=" mt-3">
                            <label>ID No.</label>
                            <input type="text" class="form-control" name="idNumber" id="idNumber" placeholder="Id No."
                              disabled onchange="chooseDiscount()">
                        </div>
                        <div class="mt-3">
                            <label>Discounted Price:</label>
                            <input type="number" class="form-control border border-primary" name="discountedPrice"
                                id="totalPrice" readonly>
                        </div>
                        <hr>
                    </div>
                    <div class="mt-3">
                        <label> Change: </label>
                        <input class="form-control border border-success" name="returnChange" id="change"
                            oninput="calculateNoDiscount()" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="btn-save-cart" id="btn-enter"
                        disabled>Enter</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    //calculate the discount price
    function chooseDiscount() {
        const selectedCustomer = document.getElementById('selectedCustomer').value;
        if (selectedCustomer == "PWD" || selectedCustomer == "Senior Citizen") {
            document.getElementById('discount').style.display = 'block';
            const originalPrice = Number(document.getElementById('inputProductPrice').value);
            const discount = Number(document.getElementById('inputDiscount').value / 100);
            const paid = Number(document.getElementById('inputPaid').value);
            const totalValue = originalPrice - (originalPrice * discount);
            const returnChange = paid - totalValue;
            document.getElementById('totalPrice').value = totalValue;
            document.getElementById('change').value = Math.round(returnChange).toFixed(2);
            document.getElementById('idNumber').disabled = false;
            document.getElementById('idNumber').required = true;
        } else {
            document.getElementById('sel').style.display = 'block';
            document.getElementById('idNumber').disabled = true;
        }
    }
    //calculate the return change of the customer 
    function calculateNoDiscount() {
        const selectedCustomer = document.getElementById('selectedCustomer').value;
        if (selectedCustomer == 'PWD' || selectedCustomer == 'Senior Citizen') {
            const originalPrice = Number(document.getElementById('totalPrice').value);
            const paid = Number(document.getElementById('inputPaid').value)
            const returnChange = paid - originalPrice;
            document.getElementById('change').value = Math.round(returnChange).toFixed(2);
            const idNumber = document.getElementById('idNumber').value;
            if (inputPaid.value.trim() >= originalPrice) {
                document.getElementById('btn-enter').disabled = false;
            } else {
                document.getElementById('btn-enter').disabled = true;
            }

        } else {
            if (selectedCustomer == "") {
                const originalPrice = Number(document.getElementById('inputProductPrice').value);
                const paid = Number(document.getElementById('inputPaid').value)
                const returnChange = paid - originalPrice;
                document.getElementById('change').value = Math.round(returnChange).toFixed(2);
                if (inputPaid.value.trim() >= originalPrice) {
                    document.getElementById('btn-enter').disabled = false;
                } else {
                    document.getElementById('btn-enter').disabled = true;
                }
            }
        }
    } 
    //enable and disable the enter button and select option 
    function EnableDisable(txtPassportNumber) {
        const selectedCustomer = document.getElementById("selectedCustomer");
        const originalPrice = Number(document.getElementById('inputProductPrice').value);
        const discountedPrice = Number(document.getElementById('totalPrice').value);
        const paid = Number(document.getElementById('inputPaid').value);

        if (inputPaid.value.trim() != "") {
            if (inputPaid.value.trim() >= originalPrice) {
                selectedCustomer.disabled = false;
            }
        } else {
            selectedCustomer.disabled = true;
        }
    }
    </script>