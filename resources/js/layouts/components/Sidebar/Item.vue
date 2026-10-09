<template>
  <el-icon>
    <HomeFilled v-if="icon === 'dashboard'"/>
    <UserFilled v-if="icon === 'user'"/>
    <Check v-if="icon === 'check'"/>
    <List v-if="icon === 'list'"/>
    <Document v-if="icon === 'document'"/>
    <Tools v-if="icon === 'setting'"/>
    <DocumentCopy v-if="icon === 'data'"/>
    <Monitor v-if="icon === 'monitor'"/>
    <Position v-if="icon === 'position'"/>
    <FolderChecked v-if="icon === 'category'"/>
    <HomeFilled v-if="icon === 'facility'"/>
    <Grid v-if="icon === 'components'"/>
    <Iphone v-if="icon === 'dhi'"/>
    <Management v-if="icon === 'evaluation'"/>
    <Place v-if="icon === 'place'"/>
    <Operation v-if="icon === 'metrics'"/>
    <UploadFilled v-if="icon === 'cloud'"/>
    <Platform v-if="icon === 'platform'"/>
    <Connection v-if="icon === 'technology'"/>
    <CollectionTag v-if="icon === 'collection'"/>
    <Discount v-if="icon === 'discount'"/>
   <House v-if="icon === 'house'"/>
   <Pointer v-if="icon === 'pointer'"/>
 <InfoFilled v-if="icon === 'infofilled'"/>
 <Checked v-if="icon === 'checked'" />
    <Trophy v-if="icon === 'trophy'"/>
    <DataLine v-if="icon === 'dataline'" />
    <Umbrella v-if="icon === 'umbrella'"  />
    <Coordinate v-if="icon === 'coordinate'"/>
   <StarFilled v-if="icon === 'star'"/>
  </el-icon>

</template>

<script>
export default {
  name: 'MenuItem',
  functional: true,
  props: {
    icon: {
      type: String,
      default: '',
    },
  }
};
</script>

<style lang="scss" scoped>
  .el-sub-menu [class^="el-icon-"] {
    text-align: left;
  }
</style> 
