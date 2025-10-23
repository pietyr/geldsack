<script setup lang="ts">
import Icon from '@/components/Icon.vue';
</script>

<template>
    <div
        class="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground"
    >
        <!--        <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />-->
        <Icon name="Wallet" color="black" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold"
            >Geld Sack</span
        >
    </div>
</template>
