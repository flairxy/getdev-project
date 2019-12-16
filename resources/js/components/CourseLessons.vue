<template>
  <ul class="fa-ul">
    <li>
      <i class="fa fa-check fa-li"></i>First item
    </li>
    <li>
      <i class="fa fa-check fa-li"></i>Second item
    </li>
    <li>
      <i class="fa fa-check fa-li"></i>Sublist
      <ul class="fa-ul">
        <li>
          <i class="fa fa-angle-right fa-li"></i>First subitem
        </li>
        <li>
          <i class="fa fa-angle-right fa-li"></i>Second subitem
        </li>
        <li>
          <i class="fa fa-angle-right fa-li"></i>Third subitem
        </li>
      </ul>
    </li>
    <li>
      <i class="fa fa-check fa-li"></i>Third item
    </li>
  </ul>
</template>
<script>
export default {
  props: {}
};
</script>

