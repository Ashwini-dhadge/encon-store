DELIMITER $$
CREATE DEFINER=CURRENT_USER PROCEDURE `procedure_stock_report_issued_all`(IN `input_company_id` INT, IN `input_site_id` INT, IN `input_from_date` DATE, IN `input_to_date` DATE, IN `input_financial_year_id` INT)
BEGIN
    -- Create temporary table
    CREATE TEMPORARY TABLE IF NOT EXISTS temp_table (
        company_id INT,
        site_id INT,
        financial_year_id INT,
        item_id INT,
        item_unit_id INT,
        batch_no VARCHAR(255),
        expired_date DATE,
        is_reserve_stock INT,
        qty DECIMAL(10, 2),
        action VARCHAR(255),
        grn_item_rate_type INT,
        os_item_rate_type INT,
        recevied_item_rate_type INT,
        grn_item_rate DECIMAL(10, 2),
        os_item_rate DECIMAL(10, 2),
        recevied_item_rate DECIMAL(10, 2),
        grn_weight_per_rate DECIMAL(10, 2),
        os_weight_per_rate DECIMAL(10, 2),
        recevied_weight_per_rate DECIMAL(10, 2),
        recevied_weight DECIMAL(10, 2)
    );

    -- Build dynamic SQL
    SET @sql = CONCAT('
        INSERT INTO temp_table (
            company_id, site_id, financial_year_id, item_id, item_unit_id,
            batch_no, expired_date, is_reserve_stock, qty, action,
            grn_item_rate_type, os_item_rate_type, recevied_item_rate_type,
            grn_item_rate, os_item_rate, recevied_item_rate,
            grn_weight_per_rate, os_weight_per_rate, recevied_weight_per_rate,
            recevied_weight
        )
        SELECT
            inv_d.company_id, inv_d.site_id, inv_d.financial_year_id,
            inv_d.item_id, inv_d.item_unit_id, inv_d.batch_no,
            inv_d.expired_date, inv_d.is_reserve_stock, inv_d.qty,
            inv_d.action,
            (SELECT grn1.item_rate_type FROM tbl_grn_items_details grn1
                JOIN tbl_grn g1 ON g1.id = grn1.grn_id
                WHERE inv_d.item_id = grn1.item_id AND inv_d.item_unit_id = grn1.item_unit_id
                AND inv_d.batch_no = grn1.batch_no AND inv_d.expired_date = grn1.expired_date
                AND g1.site_id = inv_d.site_id AND g1.financial_year_id = inv_d.financial_year_id
                ORDER BY grn1.id LIMIT 1),
            (SELECT osd1.item_rate_type FROM tbl_items_opening_stock_details osd1
                JOIN tbl_items_opening_stock os1 ON os1.id = osd1.opening_id
                WHERE inv_d.item_id = osd1.item_id AND inv_d.item_unit_id = osd1.opening_unit_id
                AND inv_d.batch_no = osd1.batch_no AND inv_d.expired_date = osd1.expired_date
                AND os1.location_id = inv_d.site_id AND os1.financial_year_id = inv_d.financial_year_id
                ORDER BY osd1.id LIMIT 1),
            (SELECT DISTINCT(CASE WHEN rece_d.weight IS NULL OR rece_d.weight = 0.00 THEN 1 ELSE 2 END)
                FROM tbl_recevied_material_issue_items_details rece_d
                JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id
                WHERE inv_d.item_id = rece_d.item_id AND inv_d.item_unit_id = rece_d.received_qty_unit
                AND inv_d.batch_no = rece_d.batch_no AND inv_d.expired_date = rece_d.expired_date
                AND rece.received_location_site_id = inv_d.site_id AND rece.financial_year_id = inv_d.financial_year_id
                ORDER BY rece_d.id LIMIT 1),
            (SELECT grn1.item_rate FROM tbl_grn_items_details grn1
                JOIN tbl_grn g1 ON g1.id = grn1.grn_id
                WHERE inv_d.item_id = grn1.item_id AND inv_d.item_unit_id = grn1.item_unit_id
                AND inv_d.batch_no = grn1.batch_no AND inv_d.expired_date = grn1.expired_date
                AND g1.site_id = inv_d.site_id AND g1.financial_year_id = inv_d.financial_year_id
                ORDER BY grn1.id LIMIT 1),
            (SELECT NULLIF(osd1.unit_rate, '''') FROM tbl_items_opening_stock_details osd1
                JOIN tbl_items_opening_stock os1 ON os1.id = osd1.opening_id
                WHERE inv_d.item_id = osd1.item_id AND inv_d.item_unit_id = osd1.opening_unit_id
                AND inv_d.batch_no = osd1.batch_no AND inv_d.expired_date = osd1.expired_date
                AND os1.location_id = inv_d.site_id AND os1.financial_year_id = inv_d.financial_year_id
                ORDER BY osd1.id LIMIT 1),
            (SELECT rece_d.rate FROM tbl_recevied_material_issue_items_details rece_d
                JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id
                WHERE inv_d.item_id = rece_d.item_id AND inv_d.item_unit_id = rece_d.received_qty_unit
                AND inv_d.batch_no = rece_d.batch_no AND inv_d.expired_date = rece_d.expired_date
                AND rece.received_location_site_id = inv_d.site_id AND rece.financial_year_id = inv_d.financial_year_id
                ORDER BY rece_d.id LIMIT 1),
            (SELECT grn1.weight_per_rate FROM tbl_grn_items_details grn1
                JOIN tbl_grn g1 ON g1.id = grn1.grn_id
                WHERE inv_d.item_id = grn1.item_id AND inv_d.item_unit_id = grn1.item_unit_id
                AND inv_d.batch_no = grn1.batch_no AND inv_d.expired_date = grn1.expired_date
                AND g1.site_id = inv_d.site_id AND g1.financial_year_id = inv_d.financial_year_id
                ORDER BY grn1.id LIMIT 1),
            (SELECT osd1.weight_per_rate FROM tbl_items_opening_stock_details osd1
                JOIN tbl_items_opening_stock os1 ON os1.id = osd1.opening_id
                WHERE inv_d.item_id = osd1.item_id AND inv_d.item_unit_id = osd1.opening_unit_id
                AND inv_d.batch_no = osd1.batch_no AND inv_d.expired_date = osd1.expired_date
                AND os1.location_id = inv_d.site_id AND os1.financial_year_id = inv_d.financial_year_id
                ORDER BY osd1.id LIMIT 1),
            (SELECT MAX(rece_d.amount / NULLIF(rece_d.received_qty, 0)) FROM tbl_recevied_material_issue_items_details rece_d
                JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id
                WHERE inv_d.item_id = rece_d.item_id AND inv_d.item_unit_id = rece_d.received_qty_unit
                AND inv_d.batch_no = rece_d.batch_no AND inv_d.expired_date = rece_d.expired_date
                AND rece.received_location_site_id = inv_d.site_id AND rece.financial_year_id = inv_d.financial_year_id
                ORDER BY rece.id LIMIT 1),
            (SELECT MAX(rece_d.weight) FROM tbl_recevied_material_issue_items_details rece_d
                JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id
                WHERE inv_d.item_id = rece_d.item_id AND inv_d.item_unit_id = rece_d.received_qty_unit
                AND inv_d.batch_no = rece_d.batch_no AND inv_d.expired_date = rece_d.expired_date
                AND rece.received_location_site_id = inv_d.site_id AND rece.financial_year_id = inv_d.financial_year_id
                ORDER BY rece.id LIMIT 1)
        FROM tbl_items_inventory_details inv_d
        LEFT JOIN tbl_grn_items_details grn ON inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.sub_ref_id = grn.id
        LEFT JOIN tbl_material_issue_items_details mi ON inv_d.type = 2 AND inv_d.ref_id = mi.issue_id AND inv_d.sub_ref_id = mi.id
        LEFT JOIN tbl_items_opening_stock_details os ON inv_d.type = 3 AND inv_d.ref_id = os.opening_id AND inv_d.sub_ref_id = os.id
        LEFT JOIN tbl_recevied_material_issue_items_details rs ON inv_d.type = 4 AND inv_d.ref_id = rs.received_id AND inv_d.sub_ref_id = rs.id
        LEFT JOIN tbl_material_issue_return_details mr ON inv_d.type = 5 AND inv_d.ref_id = mr.material_issue_return_id AND inv_d.sub_ref_id = mr.id
        LEFT JOIN tbl_items_financial_year_opening_stock_details fosd ON inv_d.type = 6 AND inv_d.ref_id = fosd.financial_year_opening_id AND inv_d.sub_ref_id = fosd.id
        WHERE grn.deleted_by IS NULL AND mi.deleted_by IS NULL AND os.deleted_by IS NULL AND rs.deleted_by IS NULL AND mr.deleted_by IS NULL
            AND inv_d.type != 6 AND inv_d.action = 2 AND inv_d.is_reserve_stock = 0
            AND inv_d.company_id = ', CAST(input_company_id AS CHAR), '
            AND inv_d.site_id = ', CAST(input_site_id AS CHAR), '
            AND inv_d.financial_year_id = ', CAST(input_financial_year_id AS CHAR), '
            AND DATE(inv_d.created_at) >= "', input_from_date, '"
            AND DATE(inv_d.created_at) <= "', input_to_date, '" 
    ');

    -- Execute the dynamic SQL
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    -- Select total
    SELECT *,CONCAT(item_id, '_',item_unit_id) AS item_key,
        SUM(
            CASE
                WHEN grn_item_rate_type = 2 AND grn_weight_per_rate != 0 THEN qty * grn_weight_per_rate
                WHEN os_item_rate_type = 2 AND os_weight_per_rate != 0 THEN qty * os_weight_per_rate
                WHEN recevied_item_rate_type = 2 AND recevied_weight_per_rate != 0 THEN qty * recevied_weight_per_rate
                WHEN recevied_item_rate_type = 1 AND recevied_item_rate != 0 THEN qty * recevied_item_rate
                WHEN os_item_rate_type = 1 AND os_item_rate != 0 THEN qty * os_item_rate
                WHEN grn_item_rate_type = 1 AND grn_item_rate != 0 THEN qty * grn_item_rate
                ELSE qty * grn_item_rate
            END
        ) AS total_amount,
        SUM(CASE WHEN action = 2 THEN qty ELSE 0 END) AS total_issued
    FROM temp_table
    GROUP BY item_id, item_unit_id;

    -- Clean up
    DROP TEMPORARY TABLE IF EXISTS temp_table;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=CURRENT_USER PROCEDURE `procedure_stock_report_issued_batch`(
    IN input_item_id INT,
    IN input_item_unit_id INT,
    IN input_company_id INT,
    IN input_site_id INT,
    IN input_from_date DATE,
    IN input_to_date DATE,
    IN input_financial_year_id INT,
    OUT out_total_issued DECIMAL(12,2),
    OUT out_total_amount DECIMAL(14,2)
)
BEGIN
    -- Set defaults
    SET out_total_issued = 0;
    SET out_total_amount = 0;

    -- Now calculate directly
    SELECT
        IFNULL(SUM(CASE WHEN inv_d.action = 2 THEN inv_d.qty ELSE 0 END), 0),
        IFNULL(SUM(
            CASE
                WHEN inv_d.action = 2 AND grn.item_rate_type = 2 AND grn.weight_per_rate IS NOT NULL AND grn.weight_per_rate != 0 THEN inv_d.qty * grn.weight_per_rate
                WHEN inv_d.action = 2 AND os.item_rate_type = 2 AND os.weight_per_rate IS NOT NULL AND os.weight_per_rate != 0 THEN inv_d.qty * os.weight_per_rate
                WHEN inv_d.action = 2 AND rece.rate_type = 2 AND rece.weight_per_rate IS NOT NULL AND rece.weight_per_rate != 0 THEN inv_d.qty * rece.weight_per_rate
                WHEN inv_d.action = 2 AND rece.rate_type = 1 AND rece.rate IS NOT NULL AND rece.rate != 0 THEN inv_d.qty * rece.rate
                WHEN inv_d.action = 2 AND os.item_rate_type = 1 AND os.unit_rate IS NOT NULL AND os.unit_rate != 0 THEN inv_d.qty * os.unit_rate
                WHEN inv_d.action = 2 AND grn.item_rate_type = 1 AND grn.item_rate IS NOT NULL AND grn.item_rate != 0 THEN inv_d.qty * grn.item_rate
                ELSE 0
            END
        ), 0)
    INTO out_total_issued, out_total_amount
    FROM tbl_items_inventory_details inv_d
    LEFT JOIN tbl_grn_items_details grn
        ON inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.sub_ref_id = grn.id
    LEFT JOIN tbl_items_opening_stock_details os
        ON inv_d.type = 3 AND inv_d.ref_id = os.opening_id AND inv_d.sub_ref_id = os.id
    LEFT JOIN tbl_recevied_material_issue_items_details rece
        ON inv_d.type = 4 AND inv_d.ref_id = rece.received_id AND inv_d.sub_ref_id = rece.id
    WHERE
        inv_d.company_id = input_company_id
        AND inv_d.site_id = input_site_id
        AND inv_d.item_id = input_item_id
        AND inv_d.item_unit_id = input_item_unit_id
        AND inv_d.financial_year_id = input_financial_year_id
        AND inv_d.is_reserve_stock = 0
        AND inv_d.action = 2
        AND DATE(inv_d.created_at) BETWEEN input_from_date AND input_to_date;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=CURRENT_USER PROCEDURE `procedure_stock_report_opening_all`(IN `input_company_id` INT, IN `input_site_id` INT, IN `input_previous_date` DATE, IN `input_to_date` DATE, IN `input_financial_year_id` INT, IN `is_first_day_opning` TINYINT)
BEGIN
    -- Create the temporary table
    CREATE TEMPORARY TABLE IF NOT EXISTS temp_table (
        company_id INT,
        site_id INT,
        financial_year_id INT,
        item_id INT,
        item_unit_id INT,
        batch_no VARCHAR(255),
        expired_date DATE,
        is_reserve_stock INT,
        qty DECIMAL(10, 2),
        action VARCHAR(255),
        grn_item_rate_type INT,
        os_item_rate_type INT,
        recevied_item_rate_type INT,
        grn_item_rate DECIMAL(10, 2),
        os_item_rate DECIMAL(10, 2),
        recevied_item_rate DECIMAL(10, 2),
        grn_weight_per_rate DECIMAL(10, 2),
        os_weight_per_rate DECIMAL(10, 2),
        recevied_weight_per_rate DECIMAL(10, 2),
        recevied_weight DECIMAL(10, 2)
    );

    -- Build dynamic SQL
    SET @sql = CONCAT(
        'INSERT INTO temp_table (
            company_id, site_id, financial_year_id, item_id, item_unit_id,
            batch_no, expired_date, is_reserve_stock, qty, action,
            grn_item_rate_type, os_item_rate_type, recevied_item_rate_type,
            grn_item_rate, os_item_rate, recevied_item_rate,
            grn_weight_per_rate, os_weight_per_rate, recevied_weight_per_rate,
            recevied_weight
        )
        SELECT 
            inv_d.company_id, inv_d.site_id, inv_d.financial_year_id, inv_d.item_id, inv_d.item_unit_id,
            inv_d.batch_no, inv_d.expired_date, inv_d.is_reserve_stock, inv_d.qty, inv_d.action,

            (SELECT grn1.item_rate_type FROM tbl_grn_items_details grn1
             JOIN tbl_grn g1 ON g1.id = grn1.grn_id
             WHERE inv_d.item_id = grn1.item_id AND inv_d.item_unit_id = grn1.item_unit_id
               AND inv_d.batch_no = grn1.batch_no AND inv_d.expired_date = grn1.expired_date
               AND g1.site_id = inv_d.site_id ORDER BY grn1.id LIMIT 1),

            (SELECT osd1.item_rate_type FROM tbl_items_opening_stock_details osd1
             JOIN tbl_items_opening_stock os1 ON os1.id = osd1.opening_id
             WHERE inv_d.item_id = osd1.item_id AND inv_d.item_unit_id = osd1.opening_unit_id
               AND inv_d.batch_no = osd1.batch_no AND inv_d.expired_date = osd1.expired_date
               AND os1.location_id = inv_d.site_id ORDER BY osd1.id LIMIT 1),

            (SELECT CASE WHEN rece_d.weight IS NULL OR rece_d.weight = 0.00 THEN 1 ELSE 2 END
             FROM tbl_recevied_material_issue_items_details rece_d
             JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id
             WHERE inv_d.item_id = rece_d.item_id AND inv_d.item_unit_id = rece_d.received_qty_unit
               AND inv_d.batch_no = rece_d.batch_no AND inv_d.expired_date = rece_d.expired_date
               AND rece.received_location_site_id = inv_d.site_id ORDER BY rece_d.id LIMIT 1),

            (SELECT grn1.item_rate FROM tbl_grn_items_details grn1
             JOIN tbl_grn g1 ON g1.id = grn1.grn_id
             WHERE inv_d.item_id = grn1.item_id AND inv_d.item_unit_id = grn1.item_unit_id
               AND inv_d.batch_no = grn1.batch_no AND inv_d.expired_date = grn1.expired_date
               AND g1.site_id = inv_d.site_id ORDER BY grn1.id LIMIT 1),

          (SELECT CAST(NULLIF(osd1.unit_rate, '''') AS DECIMAL(10,2))
 FROM tbl_items_opening_stock_details osd1
 JOIN tbl_items_opening_stock os1 ON os1.id = osd1.opening_id
 WHERE inv_d.item_id = osd1.item_id
   AND inv_d.item_unit_id = osd1.opening_unit_id
   AND inv_d.batch_no = osd1.batch_no
   AND inv_d.expired_date = osd1.expired_date
   AND os1.location_id = inv_d.site_id
 ORDER BY osd1.id
 LIMIT 1),

            (SELECT rece_d.rate FROM tbl_recevied_material_issue_items_details rece_d
             JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id
             WHERE inv_d.item_id = rece_d.item_id AND inv_d.item_unit_id = rece_d.received_qty_unit
               AND inv_d.batch_no = rece_d.batch_no AND inv_d.expired_date = rece_d.expired_date
               AND rece.received_location_site_id = inv_d.site_id ORDER BY rece_d.id LIMIT 1),

            (SELECT grn1.weight_per_rate FROM tbl_grn_items_details grn1
             JOIN tbl_grn g1 ON g1.id = grn1.grn_id
             WHERE inv_d.item_id = grn1.item_id AND inv_d.item_unit_id = grn1.item_unit_id
               AND inv_d.batch_no = grn1.batch_no AND inv_d.expired_date = grn1.expired_date
               AND g1.site_id = inv_d.site_id ORDER BY grn1.id LIMIT 1),

            (SELECT osd1.weight_per_rate FROM tbl_items_opening_stock_details osd1
             JOIN tbl_items_opening_stock os1 ON os1.id = osd1.opening_id
             WHERE inv_d.item_id = osd1.item_id AND inv_d.item_unit_id = osd1.opening_unit_id
               AND inv_d.batch_no = osd1.batch_no AND inv_d.expired_date = osd1.expired_date
               AND os1.location_id = inv_d.site_id ORDER BY osd1.id LIMIT 1),

            (SELECT MAX(rece_d.amount / NULLIF(rece_d.received_qty, 0))
             FROM tbl_recevied_material_issue_items_details rece_d
             JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id
             WHERE inv_d.item_id = rece_d.item_id AND inv_d.item_unit_id = rece_d.received_qty_unit
               AND inv_d.batch_no = rece_d.batch_no AND inv_d.expired_date = rece_d.expired_date
               AND rece.received_location_site_id = inv_d.site_id ORDER BY rece.id LIMIT 1),

            (SELECT MAX(rece_d.weight)
             FROM tbl_recevied_material_issue_items_details rece_d
             JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id
             WHERE inv_d.item_id = rece_d.item_id AND inv_d.item_unit_id = rece_d.received_qty_unit
               AND inv_d.batch_no = rece_d.batch_no AND inv_d.expired_date = rece_d.expired_date
               AND rece.received_location_site_id = inv_d.site_id ORDER BY rece.id LIMIT 1)

        FROM tbl_items_inventory_details inv_d
        LEFT JOIN tbl_grn_items_details grn ON inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.sub_ref_id = grn.id
        LEFT JOIN tbl_material_issue_items_details mi ON inv_d.type = 2 AND inv_d.ref_id = mi.issue_id AND inv_d.sub_ref_id = mi.id
        LEFT JOIN tbl_items_opening_stock_details os ON inv_d.type = 3 AND inv_d.ref_id = os.opening_id AND inv_d.sub_ref_id = os.id
        LEFT JOIN tbl_recevied_material_issue_items_details rs ON inv_d.type = 4 AND inv_d.ref_id = rs.received_id AND inv_d.sub_ref_id = rs.id
        LEFT JOIN tbl_material_issue_return_details mr ON inv_d.type = 5 AND inv_d.ref_id = mr.material_issue_return_id AND inv_d.sub_ref_id = mr.id
        LEFT JOIN tbl_items_financial_year_opening_stock_details fosd ON inv_d.type = 6 AND inv_d.ref_id = fosd.financial_year_opening_id AND inv_d.sub_ref_id = fosd.id
        WHERE grn.deleted_by IS NULL AND mi.deleted_by IS NULL AND os.deleted_by IS NULL
          AND rs.deleted_by IS NULL AND mr.deleted_by IS NULL AND inv_d.is_reserve_stock = 0
          AND inv_d.company_id = ', input_company_id,
        ' AND inv_d.site_id = ', input_site_id,
        ' AND inv_d.financial_year_id = ', input_financial_year_id
    );

    IF is_first_day_opning = 1 THEN
        SET @sql = CONCAT(@sql, ' AND inv_d.is_last_year_transfer_balance = 1');
    ELSE
      SET @sql = CONCAT(@sql,' AND ((inv_d.is_last_year_transfer_balance = 1) 
OR (DATE(inv_d.created_at) BETWEEN "', input_to_date, '" AND "', input_previous_date, '"))');

    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    -- Perform SUM operation
    SELECT 
        item_id,
        item_unit_id,CONCAT(item_id, '_',item_unit_id) AS item_key,
        SUM(CASE WHEN action = 1 THEN qty ELSE -qty END) AS balance,
        SUM(CASE
            WHEN action = 1 AND grn_item_rate_type = 2 AND grn_weight_per_rate != 0 THEN qty * grn_weight_per_rate
            WHEN action = 1 AND os_item_rate_type = 2 AND os_weight_per_rate != 0 THEN qty * os_weight_per_rate
            WHEN action = 1 AND recevied_item_rate_type = 2 AND recevied_weight_per_rate != 0 THEN qty * recevied_weight_per_rate
            WHEN action = 1 AND recevied_item_rate_type = 1 AND recevied_item_rate != 0 THEN qty * recevied_item_rate
            WHEN action = 1 AND os_item_rate_type = 1 AND os_item_rate != 0 THEN qty * os_item_rate
            WHEN action = 1 AND grn_item_rate_type = 1 AND grn_item_rate != 0 THEN qty * grn_item_rate
            WHEN action = 2 AND grn_item_rate_type = 2 AND grn_weight_per_rate != 0 THEN -qty * grn_weight_per_rate
            WHEN action = 2 AND os_item_rate_type = 2 AND os_weight_per_rate != 0 THEN -qty * os_weight_per_rate
            WHEN action = 2 AND recevied_item_rate_type = 2 AND recevied_weight_per_rate != 0 THEN -qty * recevied_weight_per_rate
            WHEN action = 2 AND recevied_item_rate_type = 1 AND recevied_item_rate != 0 THEN -qty * recevied_item_rate
            WHEN action = 2 AND os_item_rate_type = 1 AND os_item_rate != 0 THEN -qty * os_item_rate
            WHEN action = 2 AND grn_item_rate_type = 1 AND grn_item_rate != 0 THEN -qty * grn_item_rate
            ELSE 0
        END) AS total_amount
    FROM temp_table
    GROUP BY item_id, item_unit_id;

    -- Drop temp table
    DROP TEMPORARY TABLE IF EXISTS temp_table;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=CURRENT_USER PROCEDURE `procedure_stock_report_opening_batch`(
    IN input_item_id INT,
    IN input_item_unit_id INT,
    IN input_company_id INT,
    IN input_site_id INT,
    IN input_previous_date DATE,
    IN input_to_date DATE,
    IN is_first_day_opning INT,
    IN input_financial_year_id INT,
    OUT out_balance DECIMAL(12,2),
    OUT out_total_amount DECIMAL(14,2)
)
BEGIN
    DECLARE from_date DATE;
    DECLARE to_date DATE;

    -- Fix from/to date logic (your original had it reversed)
    IF is_first_day_opning = 1 THEN
        SET from_date = input_to_date;
        SET to_date = input_to_date;
    ELSE
        SET from_date = input_to_date;
        SET to_date = input_previous_date;
    END IF;

    SELECT
        IFNULL(SUM(CASE WHEN inv_d.action = 1 THEN inv_d.qty ELSE -inv_d.qty END), 0),
        IFNULL(SUM(
            CASE 
                WHEN inv_d.action = 1 AND grn.item_rate_type = 2 AND grn.weight_per_rate != 0 THEN inv_d.qty * grn.weight_per_rate
                WHEN inv_d.action = 1 AND grn.item_rate_type = 1 THEN inv_d.qty * grn.item_rate
                WHEN inv_d.action = 2 AND grn.item_rate_type = 2 AND grn.weight_per_rate != 0 THEN -1 * inv_d.qty * grn.weight_per_rate
                WHEN inv_d.action = 2 AND grn.item_rate_type = 1 THEN -1 * inv_d.qty * grn.item_rate
                ELSE 0
            END
        ), 0)
    INTO out_balance, out_total_amount
    FROM tbl_items_inventory_details inv_d
    LEFT JOIN tbl_grn_items_details grn ON inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.sub_ref_id = grn.id
    -- You can JOIN other tables if needed similarly
    WHERE inv_d.company_id = input_company_id
        AND inv_d.site_id = input_site_id
        AND inv_d.financial_year_id = input_financial_year_id
        AND inv_d.item_id = input_item_id
        AND inv_d.item_unit_id = input_item_unit_id
        AND inv_d.is_reserve_stock = 0
        AND DATE(inv_d.created_at) BETWEEN from_date AND to_date;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=CURRENT_USER PROCEDURE `procedure_stock_report_recevied_all`(IN `input_company_id` INT, IN `input_site_id` INT, IN `input_from_date` DATE, IN `input_to_date` DATE, IN `input_financial_year_id` INT)
BEGIN 
       -- Create a temporary table to hold the results 
    CREATE TEMPORARY TABLE IF NOT EXISTS temp_table ( 
        company_id INT, 
        site_id INT, 
        financial_year_id INT, 
        item_id INT, 
        item_unit_id INT, 
        batch_no VARCHAR(255), 
        expired_date DATE, 
        is_reserve_stock INT, 
        qty DECIMAL(10, 2), 
        action VARCHAR(255), 
        grn_item_rate_type INT, 
        os_item_rate_type INT, 
        recevied_item_rate_type INT, 
        grn_item_rate DECIMAL(10, 2), 
        os_item_rate DECIMAL(10, 2), 
        recevied_item_rate DECIMAL(10, 2), 
        grn_weight_per_rate DECIMAL(10, 2), 
        os_weight_per_rate DECIMAL(10, 2), 
        recevied_weight_per_rate DECIMAL(10, 2), 
        recevied_weight DECIMAL(10, 2), 
        grn_item_amount DECIMAL(10, 2), 
grn_received_qty DECIMAL(10, 2) 
    ); 
    -- Set the dynamic SQL query 
    SET @sql = CONCAT(' 
        INSERT INTO temp_table ( 
            company_id, 
            site_id, 
            financial_year_id, 
            item_id, 
            item_unit_id, 
            batch_no, 
            expired_date, 
            is_reserve_stock, 
            qty, 
            action, 
            grn_item_rate_type, 
            os_item_rate_type, 
            recevied_item_rate_type, 
            grn_item_rate, 
            os_item_rate, 
            recevied_item_rate, 
            grn_weight_per_rate, 
            os_weight_per_rate, 
            recevied_weight_per_rate, 
            recevied_weight, 
            grn_item_amount, 
            grn_received_qty 
        ) 
        SELECT 
            inv_d.company_id, 
            inv_d.site_id, 
            inv_d.financial_year_id, 
            inv_d.item_id, 
            inv_d.item_unit_id, 
            inv_d.batch_no, 
            inv_d.expired_date, 
            inv_d.is_reserve_stock, 
            inv_d.qty, 
            inv_d.action, 
            (SELECT grn1.item_rate_type   
                FROM tbl_grn_items_details grn1 
                JOIN tbl_grn g1 ON g1.id=grn1.grn_id 
                WHERE inv_d.item_id = grn1.item_id 
                    AND inv_d.item_unit_id = grn1.item_unit_id 
                    AND inv_d.batch_no = grn1.batch_no 
                    AND inv_d.expired_date = grn1.expired_date 
                    AND g1.site_id = inv_d.site_id 
                    AND g1.financial_year_id = inv_d.financial_year_id order by grn1.id limit 1), 
            (SELECT osd1.item_rate_type   
                FROM tbl_items_opening_stock_details osd1 
                JOIN tbl_items_opening_stock os1 ON os1.id=osd1.opening_id 
                WHERE inv_d.item_id = osd1.item_id 
                    AND inv_d.item_unit_id = osd1.opening_unit_id 
                    AND inv_d.batch_no = osd1.batch_no 
                    AND inv_d.expired_date = osd1.expired_date 
                    AND os1.location_id = inv_d.site_id 
                    AND os1.financial_year_id = inv_d.financial_year_id order by osd1.id limit 1), 
            (SELECT DISTINCT(CASE 
                                WHEN rece_d.weight IS NULL OR rece_d.weight = 0.00 
                                THEN 1 
                                ELSE 2 
                            END)   
                FROM tbl_recevied_material_issue_items_details rece_d 
                JOIN tbl_recevied_material_issue rece 
                    ON rece.id = rece_d.received_id 
                WHERE inv_d.item_id = rece_d.item_id 
                    AND inv_d.item_unit_id = rece_d.received_qty_unit 
                    AND inv_d.batch_no = rece_d.batch_no 
                    AND inv_d.expired_date = rece_d.expired_date 
                    AND rece.received_location_site_id = inv_d.site_id 
                    AND rece.financial_year_id = inv_d.financial_year_id order by rece_d.id limit 1), 
            (SELECT DISTINCT(grn1.item_rate) 
                FROM tbl_grn_items_details grn1 
                JOIN tbl_grn g1 ON g1.id=grn1.grn_id 
                WHERE inv_d.item_id = grn1.item_id 
                    AND inv_d.item_unit_id = grn1.item_unit_id 
                    AND inv_d.batch_no = grn1.batch_no 
                    AND inv_d.expired_date = grn1.expired_date 
                    AND g1.site_id=inv_d.site_id 
                    AND g1.financial_year_id=inv_d.financial_year_id order by grn1.id limit 1), 
(SELECT NULLIF(osd1.unit_rate, '''')
 FROM tbl_items_opening_stock_details osd1
 JOIN tbl_items_opening_stock os1 ON os1.id = osd1.opening_id
 WHERE inv_d.item_id = osd1.item_id
   AND inv_d.item_unit_id = osd1.opening_unit_id
   AND inv_d.batch_no = osd1.batch_no
   AND inv_d.expired_date = osd1.expired_date
   AND os1.location_id = inv_d.site_id
   AND os1.financial_year_id = inv_d.financial_year_id
 ORDER BY osd1.id
 LIMIT 1),
        
            (SELECT DISTINCT(rece_d.rate) 
                FROM tbl_recevied_material_issue_items_details rece_d 
                JOIN tbl_recevied_material_issue rece 
                    ON rece.id=rece_d.received_id 
                WHERE inv_d.item_id=rece_d.item_id 
                    AND inv_d.item_unit_id=rece_d.received_qty_unit 
                    AND inv_d.batch_no=rece_d.batch_no 
                    AND inv_d.expired_date=rece_d.expired_date 
                    AND rece.received_location_site_id=inv_d.site_id 
                    AND rece.financial_year_id=inv_d.financial_year_id order by rece_d.id limit 1), 
            (SELECT DISTINCT(grn1.weight_per_rate) 
                FROM tbl_grn_items_details grn1 
                JOIN tbl_grn g1 ON g1.id=grn1.grn_id 
                WHERE inv_d.item_id=grn1.item_id 
                    AND inv_d.item_unit_id=grn1.item_unit_id 
                    AND inv_d.batch_no=grn1.batch_no 
                    AND inv_d.expired_date=grn1.expired_date 
                    AND g1.site_id=inv_d.site_id 
                    AND g1.financial_year_id=inv_d.financial_year_id order by grn1.id limit 1), 
            (SELECT DISTINCT(osd1.weight_per_rate) 
                FROM tbl_items_opening_stock_details osd1 
                JOIN tbl_items_opening_stock os1 ON os1.id=osd1.opening_id 
                WHERE inv_d.item_id=osd1.item_id 
                    AND inv_d.item_unit_id=osd1.opening_unit_id 
                    AND inv_d.batch_no=osd1.batch_no 
                    AND inv_d.expired_date=osd1.expired_date 
                    AND os1.location_id=inv_d.site_id 
                    AND os1.financial_year_id=inv_d.financial_year_id order by osd1.id limit 1), 
            (SELECT MAX(rece_d.amount / NULLIF(rece_d.received_qty, 0)) 
                FROM tbl_recevied_material_issue_items_details rece_d 
                JOIN tbl_recevied_material_issue rece 
                    ON rece.id=rece_d.received_id 
                WHERE inv_d.item_id=rece_d.item_id 
                    AND inv_d.item_unit_id=rece_d.received_qty_unit 
                    AND inv_d.batch_no=rece_d.batch_no 
                    AND inv_d.expired_date=rece_d.expired_date 
                    AND rece.received_location_site_id=inv_d.site_id 
                    AND rece.financial_year_id=inv_d.financial_year_id order by rece.id limit 1), 
            (SELECT MAX(rece_d.weight) 
                FROM tbl_recevied_material_issue_items_details rece_d 
                JOIN tbl_recevied_material_issue rece 
                    ON rece.id=rece_d.received_id 
                WHERE inv_d.item_id=rece_d.item_id 
                    AND inv_d.item_unit_id=rece_d.received_qty_unit 
                    AND inv_d.batch_no=rece_d.batch_no 
                    AND inv_d.expired_date=rece_d.expired_date 
                    AND rece.received_location_site_id=inv_d.site_id 
                    AND rece.financial_year_id=inv_d.financial_year_id order by rece.id limit 1),grn.item_amount ,grn.received_qty 
        FROM 
            `tbl_items_inventory_details` inv_d 
        LEFT JOIN tbl_grn_items_details grn 
            ON inv_d.type = 1 
            AND inv_d.ref_id = grn.grn_id 
            AND inv_d.sub_ref_id = grn.id 
        LEFT JOIN tbl_material_issue_items_details mi 
            ON inv_d.type = 2 
            AND inv_d.ref_id = mi.issue_id 
             AND inv_d.sub_ref_id = mi.id 
        LEFT JOIN tbl_items_opening_stock_details os 
            ON inv_d.type = 3 
            AND inv_d.ref_id = os.opening_id 
           AND inv_d.sub_ref_id = os.id 
        LEFT JOIN tbl_recevied_material_issue_items_details rs 
            ON inv_d.type = 4 
            AND inv_d.ref_id = rs.received_id 
             AND inv_d.sub_ref_id = rs.id 
        LEFT JOIN tbl_material_issue_return_details mr 
            ON inv_d.type = 5 
            AND inv_d.ref_id = mr.material_issue_return_id 
            AND inv_d.sub_ref_id = mr.id 
        LEFT JOIN tbl_items_financial_year_opening_stock_details fosd 
            ON inv_d.type = 6 
            AND inv_d.ref_id = fosd.financial_year_opening_id 
            AND inv_d.sub_ref_id = fosd.id 
        WHERE 
            grn.deleted_by IS NULL   
            AND mi.deleted_by IS NULL 
            AND os.deleted_by IS NULL   
            AND rs.deleted_by IS NULL 
            AND mr.deleted_by IS NULL 
            AND inv_d.type != 6 
            AND inv_d.action = 1 
            AND inv_d.is_reserve_stock = 0 
            AND inv_d.company_id = ', input_company_id, ' 
            AND inv_d.site_id = ', input_site_id, '             
            AND inv_d.financial_year_id = ', input_financial_year_id 
              
    ); 
    -- Add date conditions 
    SET @sql = CONCAT(@sql, ' AND DATE(inv_d.created_at) >= "', input_from_date, '" AND DATE(inv_d.created_at) <= "', input_to_date, '"'); 
    -- Execute the dynamic SQL query 
    PREPARE stmt FROM @sql; 
    EXECUTE stmt; 
    DEALLOCATE PREPARE stmt; 
    -- Perform the SUM operation on the temporary table 
    SELECT 
        *,CONCAT(item_id, '_',item_unit_id) AS item_key, 
    SUM( 
        CASE 
            WHEN action = 1 and grn_item_rate_type IS NOT NULL AND grn_item_rate_type = 2 AND grn_weight_per_rate IS NOT NULL AND grn_weight_per_rate != 0.00 THEN qty * grn_weight_per_rate 
             WHEN action = 1 AND grn_item_rate_type IS NOT NULL AND grn_item_rate_type = 2 AND (grn_weight_per_rate IS NULL OR grn_weight_per_rate = 0.00) AND grn_item_amount != 0.00  AND grn_received_qty IS NOT NULL AND grn_received_qty != 0.00 THEN qty * (grn_item_amount / grn_received_qty) 
            WHEN action = 1 and os_item_rate_type IS NOT NULL AND os_item_rate_type = 2 AND os_weight_per_rate IS NOT NULL AND os_weight_per_rate != 0.00 THEN qty * os_weight_per_rate 
            WHEN action = 1 and recevied_item_rate_type IS NOT NULL AND recevied_item_rate_type = 2 AND recevied_weight_per_rate IS NOT NULL AND recevied_weight_per_rate != 0.00 THEN qty * recevied_weight_per_rate 
            WHEN action = 1 and recevied_item_rate_type IS NOT NULL AND recevied_item_rate_type = 1 AND recevied_item_rate IS NOT NULL AND recevied_item_rate != 0.00 THEN qty * recevied_item_rate 
            WHEN action = 1 and os_item_rate_type IS NOT NULL AND os_item_rate_type = 1 AND os_item_rate IS NOT NULL AND os_item_rate != 0.00 THEN qty * os_item_rate 
            WHEN action = 1 and grn_item_rate_type IS NOT NULL AND grn_item_rate_type = 1 AND grn_item_rate IS NOT NULL AND grn_item_rate != 0.00 THEN qty * grn_item_rate 
            ELSE 0 
        END 
    ) AS total_amount, 
    SUM(CASE WHEN action = 1 THEN qty ELSE 0 END) AS total_received 
    FROM 
        temp_table GROUP by item_id,item_unit_id; 
    -- Drop the temporary table 
    DROP TEMPORARY TABLE IF EXISTS temp_table; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=CURRENT_USER PROCEDURE `procedure_stock_report_summary_all`(IN `input_company_id` INT, IN `input_site_id` INT, IN `input_from_date` DATE, IN `input_to_date` DATE, IN `input_financial_year_id` INT)
BEGIN
    -- Drop temp tables if they already exist (but NOT stock_summary)
    DROP TEMPORARY TABLE IF EXISTS temp_opening;
    DROP TEMPORARY TABLE IF EXISTS temp_received;
    DROP TEMPORARY TABLE IF EXISTS temp_issued;

    -- Create temp result tables
    CREATE TEMPORARY TABLE temp_opening (
        item_id INT,
        item_unit_id INT,
        balance DECIMAL(10,2),
        total_amount DECIMAL(10,2)
    );

    CREATE TEMPORARY TABLE temp_received (
        company_id INT,
        site_id INT,
        financial_year_id INT,
        item_id INT,
        item_unit_id INT,
        total_received DECIMAL(10,2),
        total_amount DECIMAL(10,2)
    );

    CREATE TEMPORARY TABLE temp_issued (
        company_id INT,
        site_id INT,
        financial_year_id INT,
        item_id INT,
        item_unit_id INT,
        total_issued DECIMAL(10,2),
        total_amount DECIMAL(10,2)
    );

    CREATE TEMPORARY TABLE IF NOT EXISTS stock_summary (
        item_id INT,
        item_unit_id INT,
        item_key VARCHAR(255),
        balance DECIMAL(10,2) DEFAULT 0,
        opening_amount DECIMAL(10,2) DEFAULT 0,
        total_received DECIMAL(10,2) DEFAULT 0,
        received_amount DECIMAL(10,2) DEFAULT 0,
        total_issued DECIMAL(10,2) DEFAULT 0,
        issued_amount DECIMAL(10,2) DEFAULT 0,
        closing_qty DECIMAL(10,2) DEFAULT 0,
        closing_amount DECIMAL(10,2) DEFAULT 0
    );

    -- Populate temporary tables using existing procedures
    CALL procedure_stock_report_opening_all(input_company_id, input_site_id, input_to_date, input_from_date, 0, input_financial_year_id);
    INSERT INTO temp_opening SELECT item_id, item_unit_id, balance, total_amount FROM temp_table;

    CALL procedure_stock_report_recevied_all(input_company_id, input_site_id, input_from_date, input_to_date, input_financial_year_id);
    INSERT INTO temp_received SELECT company_id, site_id, financial_year_id, item_id, item_unit_id, total_received, total_amount FROM temp_table;

    CALL procedure_stock_report_issued_all(input_company_id, input_site_id, input_from_date, input_to_date, input_financial_year_id);
    INSERT INTO temp_issued SELECT company_id, site_id, financial_year_id, item_id, item_unit_id, total_issued, total_amount FROM temp_table;

    -- Build initial summary from opening
    INSERT INTO stock_summary (item_id, item_unit_id, item_key, balance, opening_amount)
    SELECT 
        item_id,
        item_unit_id,
        CONCAT(item_id, '_', item_unit_id),
        balance,
        total_amount
    FROM temp_opening;

    -- Merge Received
    UPDATE stock_summary ss
    JOIN temp_received r ON ss.item_id = r.item_id AND ss.item_unit_id = r.item_unit_id
    SET
        ss.total_received = r.total_received,
        ss.received_amount = r.total_amount;

    -- Merge Issued
    UPDATE stock_summary ss
    JOIN temp_issued i ON ss.item_id = i.item_id AND ss.item_unit_id = i.item_unit_id
    SET
        ss.total_issued = i.total_issued,
        ss.issued_amount = i.total_amount;

    -- Calculate Closing
    UPDATE stock_summary
    SET
        closing_qty = IFNULL(balance, 0) + IFNULL(total_received, 0) - IFNULL(total_issued, 0),
        closing_amount = IFNULL(opening_amount, 0) + IFNULL(received_amount, 0) - IFNULL(issued_amount, 0);

    -- ✅ Return result BEFORE dropping summary table
    SELECT * FROM stock_summary;

    -- Now drop temp tables
    DROP TEMPORARY TABLE IF EXISTS temp_opening;
    DROP TEMPORARY TABLE IF EXISTS temp_received;
    DROP TEMPORARY TABLE IF EXISTS temp_issued;
    DROP TEMPORARY TABLE IF EXISTS stock_summary;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=CURRENT_USER PROCEDURE `procedure_stock_report_summary_batch_bulk`(
    IN input_company_id INT,
    IN input_site_id INT,
    IN input_financial_year_id INT,
    IN input_from_date DATE,
    IN input_to_date DATE,
    IN input_previous_date DATE,
    IN is_first_day_opning INT
)
BEGIN
    -- Temp result table
    DROP TEMPORARY TABLE IF EXISTS temp_stock_summary;
    CREATE TEMPORARY TABLE temp_stock_summary (
        item_id INT,
        item_unit_id INT,
        item_group_id INT,
        opening_balance DECIMAL(12,2),
        total_opening_amount DECIMAL(14,2),
        total_received DECIMAL(12,2),
        total_received_amount DECIMAL(14,2),
        total_issued DECIMAL(12,2),
        total_issued_amount DECIMAL(14,2)
    );

    -- Insert in bulk
    INSERT INTO temp_stock_summary (
        item_id, item_unit_id, item_group_id,
        opening_balance, total_opening_amount,
        total_received, total_received_amount,
        total_issued, total_issued_amount
    )
    SELECT
        i.item_id,
        i.item_unit_id,
        t.item_group,

        -- Opening
        (SELECT out_balance FROM (
            SELECT
                IFNULL(SUM(CASE WHEN inv_d.action = 1 THEN inv_d.qty ELSE -inv_d.qty END), 0) AS out_balance
            FROM tbl_items_inventory_details inv_d
            LEFT JOIN tbl_grn_items_details grn ON inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.sub_ref_id = grn.id
            WHERE inv_d.company_id = input_company_id
              AND inv_d.site_id = input_site_id
              AND inv_d.financial_year_id = input_financial_year_id
              AND inv_d.item_id = i.item_id
              AND inv_d.item_unit_id = i.item_unit_id
              AND inv_d.is_reserve_stock = 0
              AND DATE(inv_d.created_at) BETWEEN 
                  CASE WHEN is_first_day_opning = 1 THEN input_to_date ELSE input_to_date END
                  AND CASE WHEN is_first_day_opning = 1 THEN input_to_date ELSE input_previous_date END
        ) AS sub_open),

        -- Opening Amount
        (SELECT out_total_amount FROM (
            SELECT
                IFNULL(SUM(
                    CASE 
                        WHEN inv_d.action = 1 AND grn.item_rate_type = 2 THEN inv_d.qty * grn.weight_per_rate
                        WHEN inv_d.action = 2 AND grn.item_rate_type = 2 THEN -1 * inv_d.qty * grn.weight_per_rate
                        WHEN inv_d.action = 1 AND grn.item_rate_type = 1 THEN inv_d.qty * grn.item_rate
                        WHEN inv_d.action = 2 AND grn.item_rate_type = 1 THEN -1 * inv_d.qty * grn.item_rate
                        ELSE 0
                    END
                ), 0) AS out_total_amount
            FROM tbl_items_inventory_details inv_d
            LEFT JOIN tbl_grn_items_details grn ON inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.sub_ref_id = grn.id
            WHERE inv_d.company_id = input_company_id
              AND inv_d.site_id = input_site_id
              AND inv_d.financial_year_id = input_financial_year_id
              AND inv_d.item_id = i.item_id
              AND inv_d.item_unit_id = i.item_unit_id
              AND inv_d.is_reserve_stock = 0
              AND DATE(inv_d.created_at) BETWEEN 
                  CASE WHEN is_first_day_opning = 1 THEN input_to_date ELSE input_to_date END
                  AND CASE WHEN is_first_day_opning = 1 THEN input_to_date ELSE input_previous_date END
        ) AS sub_open_amt),

        -- Received
        (SELECT out_total_received FROM (
            SELECT IFNULL(SUM(inv_d.qty), 0) AS out_total_received
            FROM tbl_items_inventory_details inv_d
            WHERE inv_d.action = 1
              AND inv_d.company_id = input_company_id
              AND inv_d.site_id = input_site_id
              AND inv_d.financial_year_id = input_financial_year_id
              AND inv_d.item_id = i.item_id
              AND inv_d.item_unit_id = i.item_unit_id
              AND inv_d.is_reserve_stock = 0
              AND DATE(inv_d.created_at) BETWEEN input_from_date AND input_to_date
        ) AS sub_rec),

        -- Received Amount
        (SELECT out_total_amount FROM (
            SELECT IFNULL(SUM(inv_d.qty * grn.item_rate), 0) AS out_total_amount
            FROM tbl_items_inventory_details inv_d
            LEFT JOIN tbl_grn_items_details grn ON inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.sub_ref_id = grn.id
            WHERE inv_d.action = 1
              AND inv_d.company_id = input_company_id
              AND inv_d.site_id = input_site_id
              AND inv_d.financial_year_id = input_financial_year_id
              AND inv_d.item_id = i.item_id
              AND inv_d.item_unit_id = i.item_unit_id
              AND inv_d.is_reserve_stock = 0
              AND DATE(inv_d.created_at) BETWEEN input_from_date AND input_to_date
        ) AS sub_rec_amt),

        -- Issued
        (SELECT out_total_issued FROM (
            SELECT IFNULL(SUM(inv_d.qty), 0) AS out_total_issued
            FROM tbl_items_inventory_details inv_d
            WHERE inv_d.action = 2
              AND inv_d.company_id = input_company_id
              AND inv_d.site_id = input_site_id
              AND inv_d.financial_year_id = input_financial_year_id
              AND inv_d.item_id = i.item_id
              AND inv_d.item_unit_id = i.item_unit_id
              AND inv_d.is_reserve_stock = 0
              AND DATE(inv_d.created_at) BETWEEN input_from_date AND input_to_date
        ) AS sub_iss),

        -- Issued Amount
        (SELECT out_total_amount FROM (
            SELECT IFNULL(SUM(inv_d.qty * grn.item_rate), 0) AS out_total_amount
            FROM tbl_items_inventory_details inv_d
            LEFT JOIN tbl_grn_items_details grn ON inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.sub_ref_id = grn.id
            WHERE inv_d.action = 2
              AND inv_d.company_id = input_company_id
              AND inv_d.site_id = input_site_id
              AND inv_d.financial_year_id = input_financial_year_id
              AND inv_d.item_id = i.item_id
              AND inv_d.item_unit_id = i.item_unit_id
              AND inv_d.is_reserve_stock = 0
              AND DATE(inv_d.created_at) BETWEEN input_from_date AND input_to_date
        ) AS sub_iss_amt)

    FROM (
        SELECT DISTINCT item_id, item_unit_id
        FROM tbl_items_inventory_details
        WHERE company_id = input_company_id
          AND site_id = input_site_id
          AND financial_year_id = input_financial_year_id
    ) AS i
    JOIN tbl_items t ON t.id = i.item_id;

    -- Output
    SELECT * FROM temp_stock_summary ORDER BY item_group_id, item_id;
END$$
DELIMITER ;
