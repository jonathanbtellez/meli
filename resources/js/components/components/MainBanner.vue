<template>
	<div class="banner">
	</div>
</template>
<script>
</script>
<style lang="scss">
	.banner{
		width: 100%;
		min-height: 125px;
		background-image: url('/storage/project/banner.jpg');
		background-attachment: local;
		background-repeat: no-repeat;
		background-size: contain;
	}
	@media (min-width: 768px){
		.banner{
			min-height: 250px;
		}
	}
	@media (min-width: 992px){
		.banner{
			min-height: 400px;
		}
	}
	@media (min-width: 1024px){
		.banner{
			min-height: 500px;
		}
	}

</style>
