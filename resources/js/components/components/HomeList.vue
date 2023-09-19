<template>
	<nav-bar :products="products" :user="user" />
	<main-banner />
	<section class="container">
		<div v-for="{ id, name } in categories" :key="id">
			<a href="/category/{{ id }}" class="fs-4 text-black link-secondary custom-link ms-3">{{ name }}</a>
			<div class="d-flex flex-row flex-wrap justify-content-around">
				<product-list :category="id" />
			</div>

		</div>
	</section>
</template>
<script>
import NavBar from './NavBar.vue'
import MainBanner from './MainBanner.vue'
import ProductList from './product/ProductList.vue';
export default {
	components: {
		NavBar,
		MainBanner,
		ProductList
	},
	props: ['user', 'products', 'categories'],
	setup(props) {
	}
}
</script>
<style lang="scss">
.custom-link {
	text-decoration: none;
}
</style>
