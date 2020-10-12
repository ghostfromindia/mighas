INSERT INTO categories(parent_category_id, category_name, slug, updated_at) 
SELECT  0,
		main_category_name, 
        main_category_code,
        now()
from pittappillil_old.main_category_tb

INSERT INTO categories(id, parent_category_id, category_name, slug, updated_at) 
SELECT  sub_category_tb.category_id,
		main_category_tb.category_id,
		sub_category_tb.sub_category_name, 
        sub_category_tb.sub_category_code,
        now()
from pittappillil_old.sub_category_tb INNER JOIN pittappillil_old.main_category_tb ON sub_category_tb.main_category_code=main_category_tb.main_category_code

INSERT INTO product_cateory_attribute_groups(id, category_id, group_name) 
SELECT  feature_set_title_id,
		sub_category_tb.category_id, 
        feature_set_title_tb.featureset_title
from pittappillil_old.feature_set_title_tb INNER JOIN pittappillil_old.sub_category_tb ON feature_set_title_tb.sub_category_code=sub_category_tb.sub_category_code

INSERT INTO product_cateory_attributes(id, category_id, attribute_name, attribute_type, group_id, show_as_variant, created_at, updated_at) 
SELECT  feature_head_tb.feature_head_id,
		sub_category_tb.category_id, 
        feature_head_tb.featurehead,
        "Running Text",
        feature_head_tb.feature_set_title_id,
        0,
        now(),
        now()
from pittappillil_old.feature_head_tb INNER JOIN pittappillil_old.feature_set_title_tb ON feature_head_tb.feature_set_title_id=feature_set_title_tb.feature_set_title_id INNER JOIN pittappillil_old.sub_category_tb ON feature_set_title_tb.sub_category_code=sub_category_tb.sub_category_code


INSERT INTO products(id, category_id, product_name, slug, brand_id, vendor_id, summary, page_heading, is_featured_in_home_page, is_featured_in_category, is_new, is_top_seller, is_today_deal, is_active, is_completed, created_by, updated_by, created_at, updated_at) 
SELECT  products_tb.id,
		sub_category_tb.category_id, 
        title,
        product_code,
        brand_id,
        1,
        products_tb.description,
        title,
        is_featured,
        0,
        is_popular,
        products_tb.is_new,
        0,
        is_active,
        1,
        1,
        1,
        now(),
        now()
from pittappillil_old.products_tb INNER JOIN pittappillil_old.sub_category_tb ON products_tb.sub_category_code=sub_category_tb.sub_category_code

INSERT INTO product_variants(id, products_id, name, slug, is_default, created_by, updated_by, created_at, updated_at) 
SELECT  products_tb.id,
		products_tb.id, 
        title,
        product_code,
        1,
        1,
        1,
        now(),
        now()
from pittappillil_old.products_tb

INSERT INTO product_inventory_by_vendor(vendor_id, variant_id, retail_price, sale_price, landing_price, available_quantity, created_at, updated_at) 
SELECT  1, 
        products_tb.id,
        price,
        offer_price,
        price,
        quantity,
        now(),
        now()
from pittappillil_old.products_tb

INSERT INTO product_attributes(products_id, attribute_id, attribute_value) 
SELECT  products_tb.id,
		feature_head_products_tb.feature_head_id, 
        feature_head_products_tb.value
from pittappillil_old.feature_head_products_tb INNER JOIN pittappillil_old.products_tb ON feature_head_products_tb.product_code=products_tb.product_code