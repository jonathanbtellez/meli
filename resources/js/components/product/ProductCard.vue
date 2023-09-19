<template >
<div class="card m-2">
			<img :src="product.image.url" class="card-img-top" alt="Product image">
			<div class="card-body">
				<h5 class="card-title">{{ product.name }}</h5>
				<p class="card-text">{{ product.format_description }}</p>
				<p class="card-text">{{ price(product.price) }}</p>
				<div class="d-flex justify-content-around">
					<a href="#" class="btn btn-secondary"><i class="fa-regular fa-eye"></i></a>
					<button class="btn btn-primary"><i class="fa-solid fa-cart-shopping"></i></button>
				</div>
			</div>
		</div>
</template>
<script>
import { moneyFormat } from '@/helper';
export default {
	props:['product']
,	setup(props) {
		return{
			price: (price) => moneyFormat(price)
		}
	}
}
</script>
