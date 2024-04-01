IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M301_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M301_ACT1
    GO
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
-- +--TEST--+
-- EXEC SPC_M301_ACT1
-- +--TEST--+
--****************************************************************************************
--*
--*  処理概要/process overview	:	Insert or update list data for M301
--*
--*  作成日/create date			:	2024/02/25
--*　作成者/creater				:	ThuanNV - ANS909
--*
--*  更新日/update date			:
--*　更新者/updater				:
--*　更新内容/update content		:
--****************************************************************************************
CREATE PROCEDURE SPC_M301_ACT1
    @P_process_prices				NVARCHAR(MAX)	= N''
,	@P_update_process_prices		NVARCHAR(MAX)	= N''
,	@P_delete_process_price			NVARCHAR(MAX)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
	-- variable general
        @w_time						DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Update, Dele'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N''

	-- INIT TEMPORARY TABLES #TMP_PROCESS_PRICE_INSERT, #TMP_PROCESS_PRICE_UPDATE, #TMP_PROCESS_PRICE_DELETE
    CREATE TABLE #TMP_PROCESS_PRICE_INSERT (
		idx							INT
    ,   item_cd						NVARCHAR(30)
    ,	category_div				SMALLINT
    ,	material_div				SMALLINT
    ,	processing_place_div		SMALLINT
    ,	number_sheet_fr		        MONEY
    ,	number_sheet_to				MONEY
    ,	color_div					SMALLINT
    ,	sales_amt					MONEY
    )
    CREATE TABLE #TMP_PROCESS_PRICE_UPDATE (
        item_cd						NVARCHAR(30)
    ,	category_div				SMALLINT
    ,	material_div				SMALLINT
    ,	processing_place_div		SMALLINT
    ,	number_sheet_fr		        MONEY
    ,	number_sheet_to				MONEY
    ,	color_div					SMALLINT
    ,	sales_amt					MONEY
    )
    CREATE TABLE #TMP_PROCESS_PRICE_DELETE (
        item_cd						NVARCHAR(30)
    ,	category_div				SMALLINT
    ,	material_div				SMALLINT
    ,	processing_place_div		SMALLINT
    ,	number_sheet_fr				MONEY
    ,	number_sheet_to				MONEY
    ,	color_div					SMALLINT
    ,	sales_amt					MONEY
    )
	-- END INIT TEMPORARY TABLES
	
	-- INSERT DATA @P_process_prices (TYPE: JSON) TO  #TMP_PROCESS_PRICE_INSERT
    INSERT INTO #TMP_PROCESS_PRICE_INSERT
    SELECT
		 ISNULL(idx, -1)										
	,	 ISNULL(item_cd, '')						  AS item_cd
	,	 category_div
	,	 material_div
	,	 processing_place_div
	,    CONVERT(MONEY, ISNULL(number_sheet_fr, 0))   AS number_sheet_fr
	,    CONVERT(MONEY, ISNULL(number_sheet_to, 0))   AS number_sheet_to
	,     color_div
	,    CONVERT(MONEY, ISNULL(sales_amt, 0))		  AS sales_amt
    FROM OPENJSON (@P_process_prices)
    WITH (
		 idx						INT
    ,    item_cd					NVARCHAR(30)
    ,	 category_div				SMALLINT
    ,	 material_div				SMALLINT
    ,	 processing_place_div		SMALLINT
    ,	 number_sheet_fr		    MONEY
    ,	 number_sheet_to			MONEY
    ,	 color_div					SMALLINT
    ,	 sales_amt					MONEY
    ) AS TMP

	--INSERT ERROR
	-- CHECK CONTAIN 
    INSERT INTO @ERR_TBL
    SELECT
        'E012'
    ,	'process_prices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.item_cd'
    ,	 0
    ,    1
    ,	 0
    ,	 ''
    ,    N'該当データが存在しません'
    FROM #TMP_PROCESS_PRICE_INSERT  AS tmp_insert WITH(NOLOCK)
    LEFT JOIN M101		 						  WITH(NOLOCK) ON (
		tmp_insert.item_cd			=  M101.item_cd 
    AND M101.item_class_div			=  2
    AND M101.del_flg				<> 1
   )
    WHERE 
			M101.item_cd IS NULL

	-- CHECKOUT DUPLICATE 
	INSERT INTO @ERR_TBL
    SELECT
         'E011'
    ,	'process_prices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.item_cd,' +
		'process_prices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.category_div,' +
	    'process_prices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.material_div,' +
		'process_prices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.processing_place_div,' +
	    'process_prices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.number_sheet_fr,' +
		'process_prices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.number_sheet_to,' +
		'process_prices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.color_div'
    ,	 0
    ,    1
    ,	 0
    ,	 ''
    ,    N'重複した値。'
    FROM #TMP_PROCESS_PRICE_INSERT   AS tmp_insert WITH(NOLOCK)
    LEFT JOIN M301								   WITH(NOLOCK) ON (
         M301.item_cd				 = tmp_insert.item_cd
    AND  M301.category_div           = tmp_insert.category_div
    AND  M301.material_div           = tmp_insert.material_div
	AND  M301.processing_place_div   = tmp_insert.processing_place_div
	AND  M301.number_sheet_fr        = tmp_insert.number_sheet_fr
	AND  M301.number_sheet_to        = tmp_insert.number_sheet_to
	AND  M301.color_div				 = tmp_insert.color_div
    AND  M301.del_flg				 <> 1
    )
    WHERE 
			M301.item_cd IS NOT NULL

	-- CHECKT ERROR
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
    BEGIN
		GOTO COMPLETE_QUERY
    END

	-- IF NOT ERROR --
	-- INSERT DATA @P_update_process_prices (TYPE: JSON) TO  #TMP_PROCESS_PRICE_UPDATE
	INSERT INTO #TMP_PROCESS_PRICE_UPDATE
    SELECT
		    ISNULL(item_cd, '')							AS item_cd
	,		category_div
	,		material_div
	,		processing_place_div
	,		CONVERT(MONEY, ISNULL(number_sheet_fr, 0))  AS number_sheet_fr
	,		CONVERT(MONEY, ISNULL(number_sheet_to, 0))  AS number_sheet_to
	,		color_div
	,		CONVERT(MONEY, ISNULL(sales_amt, 0))		AS sales_amt
    FROM OPENJSON (@P_update_process_prices)
    WITH (
			item_cd						NVARCHAR(30)
    ,		category_div				SMALLINT
    ,		material_div				SMALLINT
    ,		processing_place_div		SMALLINT
    ,		number_sheet_fr		        MONEY
    ,		number_sheet_to				MONEY
    ,		color_div					SMALLINT
    ,		sales_amt					MONEY
    ) AS TMP

	-- INSERT DATA @P_delete_process_price (TYPE: JSON) TO  #TMP_PROCESS_PRICE_DELETE
	INSERT INTO #TMP_PROCESS_PRICE_DELETE
    SELECT
			ISNULL(item_cd, '')							AS item_cd
	,		category_div
	,		material_div
	,		processing_place_div
	,		CONVERT(MONEY, ISNULL(number_sheet_fr, 0))  AS number_sheet_fr
	,		CONVERT(MONEY, ISNULL(number_sheet_to, 0))  AS number_sheet_to
	,		color_div
	,		CONVERT(MONEY, ISNULL(sales_amt, 0))		AS sales_amt
    FROM OPENJSON (@P_delete_process_price)
    WITH (
			item_cd						NVARCHAR(30)
    ,		category_div				SMALLINT
    ,		material_div				SMALLINT
    ,		processing_place_div		SMALLINT
    ,		number_sheet_fr		        MONEY
    ,		number_sheet_to				MONEY
    ,		color_div					SMALLINT
    ,		sales_amt					MONEY
    ) AS TMP

    -- START TRANSACTION
    BEGIN TRANSACTION
    -- TRY CATCH EXCEPTION
    BEGIN TRY
		-- DELETE TABLE PROCESS PRICE
        UPDATE M301 SET
			del_user_cd					= @P_act_user_cd
        ,	del_prg						= @P_prg
        ,	del_ip						= @P_ip
        ,	del_tm						= @w_time
        ,	del_flg						= 1
        FROM M301										   WITH(NOLOCK)
        INNER JOIN #TMP_PROCESS_PRICE_DELETE AS tmp_delete WITH(NOLOCK)	ON (
			M301.item_cd				= tmp_delete.item_cd
		AND	M301.category_div			= tmp_delete.category_div
		AND M301.material_div			= tmp_delete.material_div
		AND M301.processing_place_div	= tmp_delete.processing_place_div
		AND M301.number_sheet_fr		= tmp_delete.number_sheet_fr
		AND M301.number_sheet_to		= tmp_delete.number_sheet_to
		AND M301.color_div				= tmp_delete.color_div
        )

		-- UPDATE TABLE PROCESS PRICE
        UPDATE M301 SET
			sales_amt					= tmp_update.sales_amt
        ,	cre_user_cd					= IIF(del_flg = 1, @P_act_user_cd,	cre_user_cd)
        ,	cre_ip						= IIF(del_flg = 1, @P_ip,			cre_ip)
        ,	cre_prg						= IIF(del_flg = 1, @P_prg,			cre_prg)
        ,	cre_tm						= IIF(del_flg = 1, @w_time,			cre_tm)
        ,	upd_user_cd					= IIF(del_flg = 1, NULL,			@P_act_user_cd)
        ,	upd_ip						= IIF(del_flg = 1, NULL,			@P_ip)
        ,	upd_prg						= IIF(del_flg = 1, NULL,			@P_prg)
        ,	upd_tm						= IIF(del_flg = 1, NULL,			@w_time)
        ,	del_user_cd					= NULL
        ,	del_ip						= NULL
        ,	del_prg						= NULL
        ,	del_tm						= NULL
        ,	del_flg						= 0
        FROM M301										   WITH(NOLOCK)
        INNER JOIN #TMP_PROCESS_PRICE_UPDATE AS tmp_update WITH(NOLOCK) ON (
            M301.item_cd				= tmp_update.item_cd
		AND	M301.category_div			= tmp_update.category_div
		AND M301.material_div			= tmp_update.material_div
		AND M301.processing_place_div	= tmp_update.processing_place_div
		AND M301.number_sheet_fr		= tmp_update.number_sheet_fr
		AND M301.number_sheet_to		= tmp_update.number_sheet_to
		AND M301.color_div				= tmp_update.color_div
        )

		-- INSERT TABLE PROCESS PRICE WITH CONDITION M301 DOES NOT EXIST WITH del_flg = 1
        INSERT INTO M301
        SELECT
			tmp_insert.item_cd							
        ,	tmp_insert.category_div					
        ,	tmp_insert.material_div					
        ,	tmp_insert.processing_place_div			
        ,	tmp_insert.number_sheet_fr		            
        ,	tmp_insert.number_sheet_to					
        ,	tmp_insert.color_div						
        ,	tmp_insert.sales_amt						
        ,	@P_act_user_cd
        ,	@P_ip
        ,	@P_prg
        ,	@w_time
        ,	NULL
        ,	NULL
        ,	NULL
        ,	NULL
        ,	NULL
        ,	NULL
        ,	NULL
        ,	NULL
        ,	0
        FROM #TMP_PROCESS_PRICE_INSERT AS tmp_insert WITH(NOLOCK)
        LEFT JOIN M301								 WITH(NOLOCK) ON (
			 tmp_insert.item_cd					 = M301.item_cd
		AND	 tmp_insert.category_div			 = M301.category_div
		AND  tmp_insert.material_div			 = M301.material_div
		AND  tmp_insert.processing_place_div	 = M301.processing_place_div
		AND  tmp_insert.number_sheet_fr			 = M301.number_sheet_fr
		AND  tmp_insert.number_sheet_to			 = M301.number_sheet_to
		AND  tmp_insert.color_div				 = M301.color_div
		)
		WHERE 
				M301.del_flg <> 1 OR M301.del_flg IS NULL
		
		-- UPDATE TABLE PROCESS GET DATA TABLE #TMP_PROCESS_PRICE_INSERT WITH CONDITION TABLE M301 DELETED WITH del_flg = 0
		UPDATE M301 SET
                    sales_amt					= tmp_insert.sales_amt
                  ,	cre_user_cd					= IIF(del_flg = 1, @P_act_user_cd,	cre_user_cd)
                  ,	cre_ip						= IIF(del_flg = 1, @P_ip,			cre_ip)
                  ,	cre_prg						= IIF(del_flg = 1, @P_prg,			cre_prg)
                  ,	cre_tm						= IIF(del_flg = 1, @w_time,			cre_tm)
                  ,	upd_user_cd					= IIF(del_flg = 1, NULL,			@P_act_user_cd)
                  ,	upd_ip						= IIF(del_flg = 1, NULL,			@P_ip)
                  ,	upd_prg						= IIF(del_flg = 1, NULL,			@P_prg)
                  ,	upd_tm						= IIF(del_flg = 1, NULL,			@w_time)
                  ,	del_flg						= 0
        FROM M301										   WITH(NOLOCK)
        INNER JOIN #TMP_PROCESS_PRICE_INSERT AS tmp_insert WITH(NOLOCK) ON (
			M301.item_cd						= tmp_insert.item_cd
		AND	M301.category_div					= tmp_insert.category_div
		AND M301.material_div					= tmp_insert.material_div
		AND M301.processing_place_div			= tmp_insert.processing_place_div
		AND M301.number_sheet_fr				= tmp_insert.number_sheet_fr
		AND M301.number_sheet_to				= tmp_insert.number_sheet_to
		AND M301.color_div						= tmp_insert.color_div
        )
		WHERE 
				M301.del_flg = 1

    END TRY
    BEGIN CATCH
        SET @w_prs_result						= 'NG'
        SET @w_remarks							=  N'Error'															+ CHAR(13) + CHAR(10) +
												   N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')						+ CHAR(13) + CHAR(10) +
												   N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0')		+ CHAR(13) + CHAR(10) +
												   N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT
			 N'E009'
        ,	 N''
        ,	 0
        ,	 999
        ,	 0
        ,	 N''
        ,	 @w_remarks
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

    DROP TABLE IF EXISTS #TMP_PROCESS_PRICE_INSERT
    DROP TABLE IF EXISTS #TMP_PROCESS_PRICE_DELETE
    DROP TABLE IF EXISTS #TMP_PROCESS_PRICE_UPDATE
END
