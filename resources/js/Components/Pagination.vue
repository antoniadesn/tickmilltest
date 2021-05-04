<template>
  <div class="float-right" v-if="links.length > 9">
    <ul class="pagination">
        <template v-for="(link, key) in links">
            <li v-if ="link.url === null" class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" v-html="link.label" />
            </li>
            <li v-else class="page-item" :class="{ 'active': link.active }">
                <a v-if="link.active" class="page-link" href="#" v-html="link.label" />
                <a v-else class="page-link" :href="link.url" v-html="link.label" />
            </li>
        </template>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    links: Array,
  },
}
</script>