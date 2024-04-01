IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M302_ACT1]') AND type in (N'P', N'PC'))
    DROP PROCEDURE SPC_M302_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
--EXEC SPC_M302_ACT1 '[{"supplier_cd":"59","item_cd":"KZT0002","number_sheet_fr":"1","number_sheet_to":"1","category_div":3,"material_div":3,"processing_place_div":2,"color_div":1,"sales_amt":"15","supplier_nm":null,"item_nm":null,"is_new":true}]','[]','[{"supplier_cd":"59","item_cd":"KZT0002","number_sheet_fr":"1","number_sheet_to":"1","category_div":3,"material_div":3,"processing_place_div":2,"color_div":1,"sales_amt":"15","supplier_nm":null,"item_nm":null,"is_new":true}]','809','M302','172.19.0.1';
--****************************************************************************************
--* 											
--*  Process overview: insert and update data of a product
--*  
--*  Create date: 2024/02/22
--*  Creator: DungNT - ANS907
--*   					
--*  Update date:   
--*  Updater:   
--*  Update content:   
--****************************************************************************************
CREATE PROCEDURE SPC_M302_ACT1
    @P_costs								NVARCHAR(MAX)   = N''
,   @P_update_cost							NVARCHAR(MAX)   = N''
,   @P_delete_cost							NVARCHAR(MAX)   = N''
,   @P_act_user_cd							NVARCHAR(10)    = N''
,   @P_prg									NVARCHAR(30)    = N''
,   @P_ip									NVARCHAR(20)    = N''
AS
BEGIN
    SET NOCOUNT ON;
    DECLARE 
    -- general variables
        @w_time								DATETIME2       = SYSDATETIME()
    ,   @ERR_TBL							ERRTABLE
    -- log variables
    ,   @w_prs_mode							NVARCHAR(200)   = N'Update'
    ,   @w_prs_result						NVARCHAR(200)   = N'OK'
    ,   @w_remarks							NVARCHAR(200)   = N''
    ,   @w_table_key						NVARCHAR(200)   = N''

    CREATE TABLE #TMP_COSTS_INSERT (
        idx									INT
    ,   supplier_cd							NVARCHAR(30)
    ,   item_cd								NVARCHAR(30)
    ,   category_div						SMALLINT
    ,   material_div						SMALLINT
    ,   processing_place_div				SMALLINT
    ,   number_sheet_fr						MONEY
    ,   number_sheet_to						MONEY
    ,   color_div							SMALLINT
    ,   sales_amt							MONEY
    )
    CREATE TABLE #TMP_COSTS_UPDATE (
        supplier_cd							NVARCHAR(30)
    ,   item_cd								NVARCHAR(30)
    ,   category_div						SMALLINT
    ,   material_div						SMALLINT
    ,   processing_place_div				SMALLINT
    ,   number_sheet_fr						MONEY
    ,   number_sheet_to						MONEY
    ,   color_div							SMALLINT
    ,   sales_amt							MONEY
    )
    CREATE TABLE #TMP_COSTS_DELETE (
        supplier_cd							NVARCHAR(30)
    ,   item_cd								NVARCHAR(30)
    ,   category_div						SMALLINT
    ,   material_div						SMALLINT
    ,   processing_place_div				SMALLINT
    ,   number_sheet_fr						MONEY
    ,   number_sheet_to						MONEY
    ,   color_div							SMALLINT
    ,   sales_amt							MONEY
    )

	-- END INIT TEMPORARY TABLES
	
	-- INSERT DATA @P_process_prices (TYPE: JSON) TO  #TMP_PROCESS_PRICE_INSERT
    INSERT INTO #TMP_COSTS_INSERT
    SELECT
		ISNULL(idx, -1)	
    ,   ISNULL(supplier_cd, '')
    ,   ISNULL(item_cd, '')
    ,   category_div
    ,   material_div
    ,   processing_place_div
    ,   ISNULL(number_sheet_fr, '')
    ,   ISNULL(number_sheet_to, '')
    ,   color_div
    ,   ISNULL(sales_amt, '')
    FROM OPENJSON (@P_costs)
    WITH (
		idx									INT
    ,   supplier_cd							NVARCHAR(30)
    ,   item_cd								NVARCHAR(30)
    ,   category_div						SMALLINT
    ,   material_div						SMALLINT
    ,   processing_place_div				SMALLINT
    ,   number_sheet_fr						MONEY
    ,   number_sheet_to						MONEY
    ,   color_div							SMALLINT
    ,   sales_amt							MONEY
    ) AS TMP


	-- INSERT ERROR
	-- CHECK CONTAIN 
	INSERT INTO @ERR_TBL
	SELECT
			'E012'
		 ,	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.supplier_cd'
		 ,	0
		 ,  1
		 ,	0
		 ,	''
		 ,	N'該当データが存在しません'
	FROM #TMP_COSTS_INSERT
	LEFT JOIN M006 ON (
		#TMP_COSTS_INSERT.supplier_cd		=  M006.supplier_cd 
		AND M006.supplier_div				=  2
		AND M006.del_flg                    =  0
	)
	WHERE	M006.supplier_cd IS NULL
	
	INSERT INTO @ERR_TBL
	SELECT
			'E012'
		 ,	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.item_cd'
		 ,	0
		 ,  1
		 ,	0
		 ,	''
		 ,	N'該当データが存在しません'
	FROM #TMP_COSTS_INSERT
	LEFT JOIN M101 ON (
		#TMP_COSTS_INSERT.item_cd			=  M101.item_cd 
		AND M101.item_class_div             =  2
		AND M101.del_flg                    =  0
	)
	WHERE	M101.item_cd IS NULL 

	-- CHECKOUT DUPLICATE 
	INSERT INTO @ERR_TBL
    SELECT
            'E011'
         ,	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.supplier_cd,'+
         	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.item_cd,'+
         	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.category_div,'+
         	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.material_div,'+
         	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.processing_place_div,'+
         	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.number_sheet_fr,'+
         	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.number_sheet_to,'+
         	'costs.' + CONVERT(NVARCHAR, #TMP_COSTS_INSERT.idx) + '.color_div,'
         ,	 0
         ,   1
         ,	 0
         ,	 ''
         ,   N'重複した値'
    FROM #TMP_COSTS_INSERT
    LEFT JOIN M302							ON (
        M302.supplier_cd					= #TMP_COSTS_INSERT.supplier_cd
        AND M302.item_cd					= #TMP_COSTS_INSERT.item_cd
        AND M302.category_div				= #TMP_COSTS_INSERT.category_div
        AND M302.material_div				= #TMP_COSTS_INSERT.material_div
        AND M302.processing_place_div		= #TMP_COSTS_INSERT.processing_place_div
        AND M302.number_sheet_fr			= #TMP_COSTS_INSERT.number_sheet_fr
        AND M302.number_sheet_to			= #TMP_COSTS_INSERT.number_sheet_to
        AND M302.color_div					= #TMP_COSTS_INSERT.color_div
		AND M302.del_flg					<> 1
    )
    WHERE M302.supplier_cd IS NOT NULL

	

	-- CHECKT ERROR
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
    BEGIN
		GOTO COMPLETE_QUERY
    END

	

	-- IF NOT ERROR --
	-- INSERT DATA @P_update_process_prices (TYPE: JSON) TO  #TMP_PROCESS_PRICE_UPDATE


    INSERT INTO #TMP_COSTS_UPDATE
    SELECT
        ISNULL(supplier_cd, '')
    ,   ISNULL(item_cd, '')
    ,   category_div
    ,   material_div
    ,   processing_place_div
    ,   CONVERT(MONEY, ISNULL(number_sheet_fr, 0))
    ,   CONVERT(MONEY, ISNULL(number_sheet_to, 0))
    ,   color_div
    ,   CONVERT(MONEY, ISNULL(sales_amt, 0))
    FROM OPENJSON (@P_update_cost)
    WITH (
        supplier_cd							NVARCHAR(30)
    ,   item_cd								NVARCHAR(30)
    ,   category_div						SMALLINT
    ,   material_div						SMALLINT
    ,   processing_place_div				SMALLINT
    ,   number_sheet_fr						MONEY
    ,   number_sheet_to						MONEY
    ,   color_div							SMALLINT
    ,   sales_amt							MONEY
    ) AS TMP

	-- INSERT DATA @P_delete_process_price (TYPE: JSON) TO  #TMP_PROCESS_PRICE_DELETE
		
    INSERT INTO #TMP_COSTS_DELETE
    SELECT
        ISNULL(supplier_cd, '')
    ,   ISNULL(item_cd, '')
    ,   category_div
    ,   material_div
    ,   processing_place_div
    ,   CONVERT(MONEY, ISNULL(number_sheet_fr, 0))
    ,   CONVERT(MONEY, ISNULL(number_sheet_to, 0))
    ,   color_div
    ,   CONVERT(MONEY, ISNULL(sales_amt, 0))
    FROM OPENJSON (@P_delete_cost)
    WITH (
        supplier_cd							NVARCHAR(30)
    ,   item_cd								NVARCHAR(30)
    ,   category_div						SMALLINT
    ,   material_div						SMALLINT
    ,   processing_place_div				SMALLINT
    ,   number_sheet_fr						MONEY
    ,   number_sheet_to						MONEY
    ,   color_div							SMALLINT
    ,   sales_amt							MONEY
    ) AS TMP

	

    -- START TRANSACTION 
    BEGIN TRANSACTION
    -- TRY CATCH EXCEPTION
    BEGIN TRY
		
        UPDATE M302 SET
            del_user_cd						= @P_act_user_cd
        ,   del_prg							= @P_prg
        ,   del_ip							= @P_ip
        ,   del_tm							= @w_time
        ,   del_flg							= 1
        FROM M302							
        INNER JOIN #TMP_COSTS_DELETE		 ON (
            M302.supplier_cd                = #TMP_COSTS_DELETE.supplier_cd
        AND M302.item_cd					= #TMP_COSTS_DELETE.item_cd
        AND M302.category_div				= #TMP_COSTS_DELETE.category_div
        AND M302.material_div				= #TMP_COSTS_DELETE.material_div
        AND M302.processing_place_div		= #TMP_COSTS_DELETE.processing_place_div
        AND M302.number_sheet_fr			= #TMP_COSTS_DELETE.number_sheet_fr
        AND M302.number_sheet_to			= #TMP_COSTS_DELETE.number_sheet_to
        AND M302.color_div					= #TMP_COSTS_DELETE.color_div
        )

        UPDATE M302 SET
            sales_amt                       = U.sales_amt
        ,   cre_user_cd                     = IIF(M302.del_flg = 1, @P_act_user_cd, M302.cre_user_cd)
        ,   cre_ip                          = IIF(M302.del_flg = 1, @P_ip, M302.cre_ip)
        ,   cre_prg                         = IIF(M302.del_flg = 1, @P_prg, M302.cre_prg)
        ,   cre_tm                          = IIF(M302.del_flg = 1, @w_time, M302.cre_tm)
        ,   upd_user_cd                     = IIF(M302.del_flg = 1, NULL, @P_act_user_cd)
        ,   upd_ip                          = IIF(M302.del_flg = 1, NULL, @P_ip)
        ,   upd_prg                         = IIF(M302.del_flg = 1, NULL, @P_prg)
        ,   upd_tm                          = IIF(M302.del_flg = 1, NULL, @w_time)
        ,   del_user_cd                     = NULL
        ,   del_ip                          = NULL
        ,   del_prg                         = NULL
        ,   del_tm                          = NULL
        ,   del_flg                         = 0
        FROM M302							
        INNER JOIN #TMP_COSTS_UPDATE AS U   ON (
            M302.supplier_cd				= U.supplier_cd
        AND M302.item_cd					= U.item_cd
        AND M302.category_div				= U.category_div
        AND M302.material_div				= U.material_div
        AND M302.processing_place_div		= U.processing_place_div
        AND M302.number_sheet_fr			= U.number_sheet_fr
        AND M302.number_sheet_to			= U.number_sheet_to
        AND M302.color_div					= U.color_div
        )

		--select 1;return 1;
		-------------------------------------------------------------------------------
			
		-- INSERT TABLE PROCESS PRICE WITH CONDITION M302 DOES NOT EXIST WITH del_flg = 1
        INSERT INTO M302 
        SELECT
            I.supplier_cd
        ,   I.item_cd
        ,   I.category_div
        ,   I.material_div
        ,   I.processing_place_div
        ,   I.number_sheet_fr
        ,   I.number_sheet_to
        ,   I.color_div
        ,   I.sales_amt
        ,   @P_act_user_cd
        ,   @P_ip
        ,   @P_prg
        ,   @w_time
        ,   NULL
        ,   NULL
        ,   NULL
        ,   NULL
        ,   NULL
        ,   NULL
        ,   NULL
        ,   NULL
        ,   0
        FROM #TMP_COSTS_INSERT AS I			
		 LEFT JOIN M302						ON (
		    M302.supplier_cd				= I.supplier_cd
        AND M302.item_cd					= I.item_cd
        AND M302.category_div				= I.category_div
        AND M302.material_div				= I.material_div
        AND M302.processing_place_div		= I.processing_place_div
        AND M302.number_sheet_fr			= I.number_sheet_fr
        AND M302.number_sheet_to			= I.number_sheet_to
        AND M302.color_div					= I.color_div
		)
		WHERE 
				M302.del_flg <> 1 OR M302.del_flg IS NULL
	-- UPDATE TABLE PROCESS GET DATA TABLE #TMP_PROCESS_PRICE_INSERT WITH CONDITION TABLE M302 DELETED WITH del_flg = 0
		  UPDATE M302 SET
            sales_amt                       = #TMP_COSTS_INSERT.sales_amt
        ,   cre_user_cd                     = IIF(M302.del_flg = 1, @P_act_user_cd, M302.cre_user_cd)
        ,   cre_ip                          = IIF(M302.del_flg = 1, @P_ip, M302.cre_ip)
        ,   cre_prg                         = IIF(M302.del_flg = 1, @P_prg, M302.cre_prg)
        ,   cre_tm                          = IIF(M302.del_flg = 1, @w_time, M302.cre_tm)
        ,   upd_user_cd                     = IIF(M302.del_flg = 1, NULL, @P_act_user_cd)
        ,   upd_ip                          = IIF(M302.del_flg = 1, NULL, @P_ip)
        ,   upd_prg                         = IIF(M302.del_flg = 1, NULL, @P_prg)
        ,   upd_tm                          = IIF(M302.del_flg = 1, NULL, @w_time)
        ,   del_user_cd                     = NULL
        ,   del_ip                          = NULL
        ,   del_prg                         = NULL
        ,   del_tm                          = NULL
        ,   del_flg                         = 0
        FROM M302							
        INNER JOIN #TMP_COSTS_INSERT		ON (
            M302.supplier_cd				= #TMP_COSTS_INSERT.supplier_cd
        AND M302.item_cd					= #TMP_COSTS_INSERT.item_cd
        AND M302.category_div				= #TMP_COSTS_INSERT.category_div
        AND M302.material_div				= #TMP_COSTS_INSERT.material_div
        AND M302.processing_place_div		= #TMP_COSTS_INSERT.processing_place_div
        AND M302.number_sheet_fr			= #TMP_COSTS_INSERT.number_sheet_fr
        AND M302.number_sheet_to			= #TMP_COSTS_INSERT.number_sheet_to
        AND M302.color_div					= #TMP_COSTS_INSERT.color_div
		)
			WHERE M302.del_flg				= 1
    END TRY
    BEGIN CATCH
        SET @w_prs_result					= 'NG'
        SET @w_remarks						= N'Error'																+ CHAR(13) + CHAR(10) +
											N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')						+ CHAR(13) + CHAR(10) +
											N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0')		+ CHAR(13) + CHAR(10) +
											N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT
                 N'E009'
             ,   N''
             ,   0
             ,   999
             ,   0
             ,	 N''
             ,   @w_remarks
    END CATCH

    IF EXISTS (SELECT 1 FROM @ERR_TBL)
    BEGIN
        IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
    END
    ELSE
        BEGIN
            DELETE FROM @ERR_TBL
            IF(@@TRANCOUNT > 0)
            BEGIN
                COMMIT TRANSACTION
        END
    END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

    SELECT * FROM @ERR_TBL

    DROP TABLE IF EXISTS #TMP_COSTS_INSERT
    DROP TABLE IF EXISTS #TMP_COSTS_UPDATE
    DROP TABLE IF EXISTS #TMP_COSTS_DELETE
END
