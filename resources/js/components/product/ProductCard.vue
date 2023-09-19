<template >
	<div class="card mx-2 mb-4 d-flex">
		<img :src="product.image.url" class="card-img-top" alt="Product image">
		<div class="card-body">
			<h5 class="card-title">{{ product.name }}</h5>
			<p class="card-text">{{is_main ? product.description :product.format_description }}</p>
			<p class="card-text fw-bold fs-5">Price: <span class="fw-normal">{{ price(product.price) }}</span></p>
		</div>
		<div class="card-footer">
			<div class="d-flex justify-content-around">

				<a v-if="!is_main" @click="go_to_product(product.id)" class="btn btn-secondary"><i class="fa-regular fa-eye"></i><span class="button-card-label"> See more</span></a>
				<button class="btn btn-primary"><i class="fa-solid fa-cart-shopping"></i><span class="button-card-label"> Add</span></button>
			</div>
		</div>
	</div>
</template>
<script>
import { moneyFormat } from '@/helper';
export default {
	props: ['product', 'is_main'],
	setup(props) {
		return {
			price: (price) => moneyFormat(price),
			go_to_product: (id) => window.location.href = `/product/${id}`
		}

		// TODO handle add car
	}
}
</script>
<style lang="scss" scoped>
.button-card-label {
	display: none;
}

@media (min-width: 767px) {
	.button-card-label {
		display: inline;
	}
}
</style>
