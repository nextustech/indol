<div class="row">
    <div class="col-lg-12 print-none">
<?php
   if(isset($dateFilter)){
       $dateTm = $dateFilter;
   }

?>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">Today's Net Cash  @ ( {{ $dateTm }} )</h5>
            </div>

            <div class="card-body">
                <table class="table table-sm">

                    <tbody>

                            <tr>
                                <td>Total Collection - <b> ₹ {{ $collections->sum('amount') }}</b> </td>
                                <td>Total Refund - <b> ₹ {{ $refunds->sum('refund') }}</b> </td>
                                <td>Total Expense -  <b> ₹ {{ $expenses->sum('amount') }}</b> </td>
                                <td> Today Net Amount - <b> ₹ {{ $collections->sum('amount') - ( $refunds->sum('refund') + $expenses->sum('amount')) }}</b>  </td>


                            </tr>
                            <tr>
                                <td>Total Cash Collection - <b> ₹ {{ $todayCashCollections }}</td>
                                <td>Total Cash Refund - <b> ₹ {{ $todayCashRefund  }} </td>
                                <td>Total Cash Expense - <b> ₹ {{ $todayCashExps }} </td>
                                <td>Net Cash - <b> ₹ {{ $todayCashCollections - ( $todayCashRefund + $todayCashExps) }} </b></td>


                            </tr>
                            <tr>
                              <?php
                              	$onlineCollection = $collections->sum('amount') - $todayCashCollections;
                              	$onlineRefund = $refunds->sum('refund') - $todayCashRefund;
                              	$onlineExpense = $expenses->sum('amount')  - $todayCashExps;
                              ?>
                                <td>Total Online Collection - <b> ₹ {{ $collections->sum('amount') - $todayCashCollections }}</td>
                                <td>Total Online Refund - <b> ₹ {{ $refunds->sum('refund') - $todayCashRefund  }} </td>
                                <td>Total Online Expense - <b> ₹ {{ $expenses->sum('amount')  - $todayCashExps }} </td>
                                <td>Net Online - <b> ₹ {{ $onlineCollection - ( $onlineRefund + $onlineExpense) }}</b></td>


                            </tr>
                    </tbody>
                </table>


            </div>
            <!-- /.card-body -->

        </div>
    </div>
</div>
<!-- /.row -->
