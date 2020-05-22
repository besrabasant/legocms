<template>
  <legocms-panel name="listings">
    <div class="listings">
      <div class="listings__actions">
        <slot name="actions"><span class="placeholder">Actions</span></slot>
      </div>
      <table class="listings__table">
        <thead>
          <tr>
            <th class="listings__ghost-cell"></th>
            <slot name="header">
              <legocms-listings-header column="name">Name</legocms-listings-header>
            </slot>
            <th class="listings__col-actions"></th>
          </tr>
        </thead>
        <tbody>
          <slot>
            <legocms-listings-row name="John Doe"></legocms-listings-row>
            <legocms-listings-row name="Jane Doe"></legocms-listings-row>
          </slot>
        </tbody>
      </table>
      <div class="listings__pagination">
        <span class="placeholder">Pagination</span>
      </div>
    </div>
  </legocms-panel>
</template>

<script>
export default {
  name: "LegoCMSListings",
};
</script>
