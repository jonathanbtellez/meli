<template >
	<template v-if="is_loading">
		<div class="loader"></div>
	</template>
	<template v-else>
		<div v-for="product in products_by_category" :key="product.id" class="card-size">
			<product-card :product="product"/>
		</div>
	</template>
</template>
<script>

import ProductCard from './ProductCard.vue';
import { onMounted, ref } from 'vue';

export default {
	components:{
		ProductCard
	},
	props: ['category'],
	setup(props) {
		const products_by_category = ref({})
		const is_loading = ref(true)

		//TODO: Add shopping car

		const getProductsByCategory = async (id) => {
			try {
				const { data } = await axios(`/product/getByCategory/${id}`)
				products_by_category.value = data.products.slice(0, 5)
				is_loading.value = false
			} catch (error) {
				console.error(error);
			}
		}
		onMounted(async () => {
			await getProductsByCategory(props.category)
		})

		return {
			products_by_category,
			is_loading
		}
	}
}
</script>
<style lang="scss">
.card-size {
	width: 48%;
}
/* HTML:  */
.loader {
  width: 15px;
  aspect-ratio: 1;
  position: relative;
  animation: l9-0 1.5s infinite steps(2);
}
.loader::before,
.loader::after {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: #000;
}
.loader::before {
  box-shadow: 26px 0;
  transform: translateX(-26px);
  animation: l9-1 .75s infinite linear alternate;
}
.loader::after {
  transform: translateX(13px) rotate(0deg) translateX(13px);
  animation: l9-2 .75s infinite linear alternate;
}
@keyframes l9-0 {
    0% ,49.9% {transform: scale(1)}
    50%,100%  {transform: scale(-1)}
}
@keyframes l9-1 {
    100%{box-shadow: 52px 0}
}
@keyframes l9-2 {
    100%{transform: translateX(13px) rotate(-180deg) translateX(13px)}
}

@media (min-width: 991px) {
	.card-size {
		width: 19%;
	}
}
</style>
