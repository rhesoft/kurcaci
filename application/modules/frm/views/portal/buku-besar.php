<table class="table table-bordered">
  <tr>
    <th>Total Debit</th>
    <th style="text-align: right"><?php print number_format($total['debit'], 0, ",", ".")?></th>
  </tr>
  <tr>
    <th>Total Kredit</th>
    <th style="text-align: right"><?php print number_format($total['kredit'], 0, ",", ".")?></th>
  </tr>
  <tr>
    <th>
      Saldo
      <?php
      $saldo = $total['debit']-$total['kredit'];
      if($saldo < 0)
        print "(Kredit)";
      else if($saldo > 0)
        print "(Debit)";
      ?>
    </th>
    <th style="text-align: right"><?php print number_format(abs($saldo), 0, ",", ".")?></th>
  </tr>
</table>
<hr />
<table class="table table-bordered">
  <thead>
    <tr>
        <th>Tanggal</th>
        <th>Note</th>
        <th>No Ref</th>
        <th>Debit</th>
        <th>Kredit</th>
    </tr>
  </thead>
  <tbody id="data_list">
    
  </tbody>
  <tfoot>
    <tr>
      <th colspan="6"></th>
    </tr>
  </tfoot>
</table>
<div class="box-footer clearfix" id="halaman_set">
    <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="#">«</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">»</a></li>
    </ul>
</div>