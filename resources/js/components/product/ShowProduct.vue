<template>
	<nav-bar :products="products" :user="user" :title="product.name" />
	<main-banner />
	<section class="container">
		<div class="d-flex justify-content-between m-3 align-items-baseline">
			<h2 class="fs-4 ">{{ product.name }}</h2>
			<a href="/" class="btn btn-secondary">Go home</a>
		</div>
		<div class="d-flex justify-content-center">
			<product-card :product="product" :is_main="true" class="card-size" />
		</div>
	</section>
	<v-footer/>
</template>
<script>
import ProductCard from '../product/ProductCard.vue';
export default {
	components: {
		ProductCard
	},
	props: ['user', 'products', 'product'],
	setup(props) {
	}
}
</script>
<style lang="scss" scoped>
.card-size {
	width: 80%;
	margin: auto;
}

@media(min-width: 1024px) {
	.card-size {
		width: 65%;
	}
}
</style>

