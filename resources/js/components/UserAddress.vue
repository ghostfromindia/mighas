<div class="address-card__badge" v-if="default==1 && from == 'home'">Default Address</div>
<div class="address-card__badge" v-else="default==1">Default</div>
<div class="address-card__body">
   <div class="address-card__name">{{full_name}}</div>
   <div class="address-card__row" v-html="address"></div>
   <div class="address-card__row">
      <div class="address-card__row-title">Phone Number</div>
      <div class="address-card__row-content">{{phone}}</div>
   </div>
   <div class="address-card__row">
      <div class="address-card__row-title">Address Type</div>
      <div class="address-card__row-content" v-if="type == 1">Home</div>
      <div class="address-card__row-content" v-else>Work</div>
   </div>
   <div class="address-card__footer">
      <a href="">Edit</a>&nbsp;&nbsp;
      <a href="">Remove</a>
   </div>
</div>