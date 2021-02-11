<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-dollar"></i>&nbsp;Invoice
        <small>#INV-000567F7-00</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Projects</a></li>
        <li class="active">Invoice</li>
      </ol>
    </section>

    <!--<div class="pad margin no-print">-->
      <!--<div class="callout callout-info" style="margin-bottom: 0!important;">-->
        <!--<h4><i class="fa fa-info"></i> Note:</h4>-->
        <!--This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.-->
      <!--</div>-->
    <!--</div>-->

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> AllRenos, Inc.
            <small class="pull-right">
              <p><strong>Date:</strong> March 24, 2018</p>

            </small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">

        <div class="row content">

          <div class="col-sm-6">

            <h5>From</h5>

            <address>

              <strong>Twitter, Inc.</strong><br>

              795 Folsom Ave, Suite 600<br>

              San Francisco, CA 94107<br>

              <abbr title="Phone">P:</abbr> (123) 456-7890

            </address>

          </div><!-- /col-sm-6 -->



          <div class="col-sm-6 text-right">

            <h5 class="subtitle mb10">Invoice No.</h5>

            <h4 class="text-primary">INV-000567F7-00</h4>

            <h5 class="subtitle mb10">To</h5>

            <address>

              <strong>Twitter, Inc.</strong><br>

              795 Folsom Ave, Suite 600<br>

              San Francisco, CA 94107<br>

              <abbr title="Phone">P:</abbr> (123) 456-7890

            </address>

            <p><strong>Due Date:</strong> March 26, 2018</p>

          </div><!--/ col-sm-6 -->

        </div>
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Product</th>
              <th>Serial #</th>
              <th>Description</th>
              <th class="text-right">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1</td>
              <td>Call of Duty</td>
              <td>455-981-221</td>
              <td>El snort testosterone trophy driving gloves handsome</td>
              <td class="text-right">$64.50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Need for Speed IV</td>
              <td>247-925-726</td>
              <td>Wes Anderson umami biodiesel</td>
              <td class="text-right">$50.00</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Monsters DVD</td>
              <td>735-845-642</td>
              <td>Terry Richardson helvetica tousled street art master</td>
              <td class="text-right">$10.70</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Grown Ups Blue Ray</td>
              <td>422-568-642</td>
              <td>Tousled lomo letterpress</td>
              <td class="text-right">$25.99</td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Methods:</p>
          <img src="~assets/img/credit/visa.png" alt="Visa">
          <img src="~assets/img/credit/mastercard.png" alt="Mastercard">
          <img src="~assets/img/credit/american-express.png" alt="American Express">
          <img src="~assets/img/credit/paypal2.png" alt="Paypal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Thank you for your business. Please make sure all cheques payable to Company, Inc. Account No. 65148374
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">

          <div class="table-responsive">
            <table class="table table-striped">
              <tr>
                <th class="text-right" style="width:50%">Subtotal:</th>
                <td class="text-right">$250.30</td>
              </tr>
              <tr>
                <th class="text-right">Tax (9.3%)</th>
                <td class="text-right">$10.34</td>
              </tr>
              <tr >
                <th class="text-right">Total:</th>
                <td class="text-right">$260.64</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-envelope-o"></i> Send Email
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
</template>

<script>

  export default {
    name: 'invoice',
    components: {
    },
    data () {
      return {
      }
    },
    mixins: [
    ],
    methods: {

    }
  }

</script>

<style lang="scss" scoped>

</style>
