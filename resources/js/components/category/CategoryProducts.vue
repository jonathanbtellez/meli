<template>
	<nav-bar :products="products" :user="user" :title="category.name" />
	<main-banner />
	<section class="container">
		<div class="d-flex flex-row justify-content-between m-2 align-items-baseline">
			<h2 class="fs-4 m-0">{{ category.name }}</h2>
			<a href="/" class="btn btn-secondary">Go home</a>
		</div>
		<div class="w-100 d-md-flex flex-wrap">
			<div v-for="product in categories" :key="product.id" class="card-size">
				<product-card :product="product" />
			</div>
		</div>
	</section>
	<v-footer />
</template>
<script>
import ProductCard from '../product/ProductCard.vue';
export default {
	components: {
		ProductCard
	},
	props: ['user', 'products', 'categories', 'category'],
	setup(props) {
	}
}
</script>
