<template>
  <legocms-panel name="listings">
    <div class="listings">
      <div class="listings__actions">
        <slot name="actions">Actions</slot>
      </div>
      <table class="listings__table">
        <thead>
          <tr>
            <th class="listings__ghost-item"></th>
            <slot name="header">
              <legocms-listings-header column="name">Name</legocms-listings-header>
            </slot>
          </tr>
        </thead>
        <tbody>
          <legocms-listings-row name="John Doe"></legocms-listings-row>
          <legocms-listings-row name="Jane Doe"></legocms-listings-row>
        </tbody>
      </table>
    </div>
  </legocms-panel>
</template>

<script>
export default {
  name: "LegoCMSListings",
};
</script>
