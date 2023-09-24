<template >
	<div class="card d-flex h-100 mx-2">
		<div class="m-auto my-2 d-flex align-items-center h-50">
			<img :src="product.image.url" class="card-img-top" alt="Product image">
		</div>
		<div class="card-body">
			<h5 class="card-title fw-bold">{{ product.name }}</h5>
			<p class="card-text">{{ is_main ? product.description : product.format_description }}</p>
			<p class="card-text fw-bold fs-6">Price: <span class="fw-normal">{{ price(product.price) }}</span></p>
		</div>
		<div class="p-2 bg-body-secondary">
			<div class="d-flex justify-content-around">
				<button v-if="!is_main" @click="go_to_product(product.id)" class="btn btn-secondary"><i
						class="fa-regular fa-eye"></i></button>
				<button class="btn btn-primary" @click="handle_add_product(product.id)"><i
						class="fa-solid fa-cart-shopping"></i>{{
							is_main && ' Add shopping cart' }}</button>
			</div>
		</div>
	</div>
</template>
<script>
import useLocalStorage from "@/composables/useLocalStorage";
import useShoppingCart from '@/composables/useShoppingCart';
import useToast from '@/composables/useToast';
import { moneyFormat } from '@/helper';
export default {
	props: ['product', 'is_main'],
	setup(props) {
		const { getStorage } = useLocalStorage();
		const { add_product } = useShoppingCart()
		const { openToast } = useToast()

		/**
		 * Check if the user exist, if the result is true add the product and a toast
		 * @param {number} id
		 */
		const handle_add_product = (id) => {
			const user_logged = getStorage('user')
			if (!user_logged) {
				openToast('Please login to buy', 'warning')
				return
			}
			add_product(id, user_logged.id)
			openToast('You have added this product to shopping cart', 'success')
		}

		return {
			price: (price) => moneyFormat(price),
			go_to_product: (id) => window.location.href = `/product/${id}`,
			handle_add_product
		}

		// TODO handle add car
	}
}
</script>
