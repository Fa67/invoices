@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="columns">
            <div class="column">
                <h3 class="title">
                    Editare factura
                </h3>
            </div>
            <div class="column">
                <!-- Right side -->
                <div class="level-right">
                    <a class="button" href="{{url()->previous()}}" style="text-decoration: none">Back</a>
                </div>
            </div>
        </div>
        <form  method="POST" action="/invoices/{{$invoice->id}}">
            @csrf
            @method('PATCH')
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Client</label>
                        <div class="control">
                            <input class="input is-small" type="text" value = "{{$invoice->client}}" name = "client" placeholder="Client" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Invoice Number</label>
                        <div class="control">
                            <input class="input is-small" type="text" value = "{{$invoice->invoiceNo}}" name = "invoiceNo" placeholder="Invoice No" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Client Address</label>
                        <div class="control">
                            <input class="input is-small" type="text" name = "clientAddress" value = "{{$invoice->clientAddress}}" placeholder="Client Address" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Reference</label>
                        <div class="control">
                            <input class="input is-small" type="text" value = "{{$invoice->title}}" name = "title" placeholder="Reference" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Invoice Date</label>
                        <div class="control">
                            <input class="input is-small" type="date" value = "{{$invoice->invoiceDate}}" name = "invoiceDate" placeholder="Invoice Date" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Due Date</label>
                        <div class="control">
                            <input class="input is-small" type="date" value = "{{$invoice->dueDate}}" name = "dueDate" placeholder="Due Date" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Status</label>
                        <div class="select is-small" required>
                            <select name = "status">
                                <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @for ($i = 0; $i < count($invoice->invoiceItems->pluck('item')); $i++)
                <div class="columns itemsRow is-vcentered">
                    <div class="column">
                        <div class="field">
                            <label class="label">Item description</label>
                            <div class="control">
                                <input class="input is-small" type="text" value = "{{$invoice->invoiceItems->pluck('item')[$i]}}" name = "item[]" placeholder="Item description" required>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Unit price</label>
                            <div class="control">
                                <input class="input is-small" type="number" value = "{{$invoice->invoiceItems->pluck('unitPrice')[$i]}}" name = "unitPrice[]" placeholder="Unit price" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Quantity</label>
                            <div class="control">
                                <input class="input is-small" type="number" value = "{{$invoice->invoiceItems->pluck('qty')[$i]}}" name = "qty[]" placeholder="Quantity" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Total</label>
                            <div class="control">
                                <input class="input is-small" type="number" value = "{{$invoice->invoiceItems->pluck('qty')[$i] * $invoice->invoiceItems->pluck('unitPrice')[$i]}}" name = "total[]" placeholder="" readonly >
                            </div>
                        </div>
                    </div>
                    <div class="column is-1">
                        <a class="button is-danger is-outlined is-small">
                            <span class="icon is-small">
                                <i class="fas fa-times"></i>
                            </span>
                        </a>
                    </div>
                </div>
            @endfor
            <div class="columns">
                <div class="column is-2">
                    <!-- left side -->
                    <div class="field is-pulled-left">
                        <p class="control">
                            <a id = "addRow" class="button is-primary is-outlined is-small" style="text-decoration: none">Add row</a>
                        </p>
                    </div>
                </div>
                <div class="column is-3 is-offset-6">
                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label class="label">Subtotal</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-small" type="number" value = "{{$invoice->subTotal}}" name = "subTotal" placeholder="Subtotal" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-1">
                    <label class="label">RON</label>
                </div>
            </div>
            <div class="columns">
                <div class="column is-3 is-offset-8">
                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label class="label">Discount</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-small" type="number" value = "{{$invoice->discount}}" name = "discount" placeholder="Discount" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-1">
                    <label class="label">%</label>
                </div>
            </div>
            <div class="columns">
                <div class="column is-4">
                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label class="label">Terms and Conditions</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <textarea class="input is-small" name = "termsAndConditions" placeholder="Terms and conditions">{{$invoice->termsAndConditions}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3 is-offset-4">
                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label class="label">Grand Total</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-small" type="number" value = "{{$invoice->grandTotal}}" name = "grandTotal" placeholder="Total" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-1">
                    <label class="label">RON</label>
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link">Save</button>
                </div>
                <div class="control">
                    <button class="button is-text">Cancel</button>
                </div>
            </div>
            @include ('invoices.errors')
        </form>
    </div>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {

            function updatePrice() {

                let total;
                let price;
                let qty;
                if (this.name === 'unitPrice[]'){
                    price = $( this ).val();
                }
                else{
                    price = $( this ).closest('.itemsRow').find('input[name="unitPrice[]"]').val();
                }

                if (this.name === 'qty[]'){
                    qty = $( this ).val();
                }
                else{
                    qty = $( this ).closest('.itemsRow').find('input[name="qty[]"]').val();
                }

                total = price* qty;

                $( this ).closest('.itemsRow').find('input[name="total[]"]').val(total);

                updateSubtotal();

            }

            function updateSubtotal() {

                let subTotal = 0;


                $( ".itemsRow" ).each(function() {
                    let rowTotal = $( this ).find('input[name="total[]"]').val();
                    subTotal += (+rowTotal);    // unary operator
                });
                $('input[name="subTotal"]').val(subTotal);

                updateGrandTotal();

            }

            function updateGrandTotal() {

                let grandTotal = 0;

                let subTotal = $('input[name="subTotal"]').val();
                let discount = $('input[name="discount"]').val();

                grandTotal = (+subTotal) - (+discount)*(+subTotal)/100;

                $('input[name="grandTotal"]').val(grandTotal);

            }

            $(document).on('click', '#addRow', function () {

                let row = '';

                row += '\
                    <div class="columns itemsRow is-vcentered">\
                    <div class="column">\
                        <div class="field">\
                            <label class="label">Item description</label>\
                            <div class="control">\
                                <input class="input is-small" type="text" value = "" name = "item[]" placeholder="Item description" required>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="column">\
                        <div class="field">\
                            <label class="label">Unit price</label>\
                            <div class="control">\
                                <input class="input is-small" type="number" value = "" name = "unitPrice[]" placeholder="Unit price" min="0" required>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="column">\
                        <div class="field">\
                            <label class="label">Quantity</label>\
                            <div class="control">\
                                <input class="input is-small" type="number" value = "1" name = "qty[]" placeholder="Quantity" min="1" required>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="column">\
                        <div class="field">\
                            <label class="label">Total</label>\
                            <div class="control">\
                                <input class="input is-small" type="number" value = "" name = "total[]" placeholder="" readonly >\
                            </div>\
                        </div>\
                    </div>\
                    <div class="column is-1">\
                        <a class="button is-danger is-outlined is-small">\
                            <span class="icon is-small">\
                                <i class="fas fa-times"></i>\
                            </span>\
                        </a>\
                    </div>\
                 </div>\
                ';

                // paste after last invoice item
                $(".itemsRow:last").after(row);

                row = '';
                console.log(row);

            });

            $(document).on('click', '.is-danger:not([disabled])', function () {
                $(this).closest(".itemsRow").remove();
            });

            $(document).on("keyup mouseup", "input[name='qty[]'], input[name='unitPrice[]']", updatePrice);
            $(document).on("keyup change mouseup", "input[name='discount']", updateGrandTotal);
        });

    </script>
@stop
