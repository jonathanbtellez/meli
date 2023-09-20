<template>
	<nav-bar :products="products" :user="user" :title="category.name" />
	<main-banner />
	<section class="container">
		<h2 class="fs-4 m-3">{{ category.name }}</h2>
		<div class="d-flex flex-row flex-wrap">
			<div v-for="product in categories" :key="product.id" class="card-size">
				<product-card :product="product" />
			</div>
		</div>
	</section>
</template>
<script>
import ProductCard from '../product/ProductCard.vue';
export default {
	components: {
		ProductCard
	},
	props: ['user', 'products', 'categories', 'category'],
	setup(props) {
		console.log(props.category);
	}
}
</script>
<style lang="scss" scoped>
.custom-link {
	text-decoration: none;
}

.card-size {
	width: 48%;
}

@media (min-width: 991px) {
	.card-size {
		width: 19%;
	}
}
</style>
