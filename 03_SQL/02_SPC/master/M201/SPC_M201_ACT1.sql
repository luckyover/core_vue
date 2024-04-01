IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M201_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M201_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- 
--****************************************************************************************
--*  
--*  処理概要/process overview	:	Save data of a product price
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	QuanLH - ANS902
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M201_ACT1
	@P_sizes_prices					NVARCHAR(MAX)	= N''
,	@P_update_sizes_prices			NVARCHAR(MAX)	= N''
,	@P_delete_sizes_price			NVARCHAR(MAX)	= N''
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
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Update'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N''

	-- INIT TEMPORARY TABLES #TMP_SIZES_PRICE_INSERT, #TMP_SIZES_PRICE_UPDATE, #TMP_SIZES_PRICE_DELETE
    CREATE TABLE #TMP_SIZES_PRICE_INSERT (
		idx							INT
    ,   item_cd						NVARCHAR(30)
    ,	color_cd					NVARCHAR(10)
    ,	size_cd						NVARCHAR(10)
    ,	price_list					SMALLINT
    ,	retail_upr					MONEY
    )
    CREATE TABLE #TMP_SIZES_PRICE_UPDATE (
        item_cd						NVARCHAR(30)
    ,	color_cd					NVARCHAR(10)
    ,	size_cd						NVARCHAR(10)
    ,	price_list					SMALLINT
    ,	retail_upr					MONEY
    )
    CREATE TABLE #TMP_SIZES_PRICE_DELETE (
        item_cd						NVARCHAR(30)
    ,	color_cd					NVARCHAR(10)
    ,	size_cd						NVARCHAR(10)
    ,	price_list					SMALLINT
    ,	retail_upr					MONEY
    )
	-- END INIT TEMPORARY TABLES
	
	-- INSERT DATA @P_sizes_prices (TYPE: JSON) TO  #TMP_SIZES_PRICE_INSERT
    INSERT INTO #TMP_SIZES_PRICE_INSERT
    SELECT
		 ISNULL(idx, -1)								  AS idx
	,	 ISNULL(item_cd, SPACE(0))						  AS item_cd
	,	 ISNULL(color_cd, SPACE(0))						  AS color_cd
	,	 ISNULL(size_cd, SPACE(0))						  AS size_cd
	,	 price_list	
	,    CONVERT(MONEY, ISNULL(retail_upr, 0))				AS retail_upr
    FROM OPENJSON (@P_sizes_prices)
    WITH (
		 idx						INT
    ,    item_cd					NVARCHAR(30)
    ,	 color_cd					NVARCHAR(10)
    ,	 size_cd					NVARCHAR(10)
    ,	 price_list					SMALLINT
    ,	 retail_upr					MONEY
    ) AS TMP

	--INSERT ERROR
	-- CHECK CONTAIN 
    INSERT INTO @ERR_TBL
    SELECT
         N'E012'
    ,	 N'sizePrices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.item_cd'
    ,	 0
    ,    1
    ,	 0
    ,	 N''
    ,    N'該当データが存在しません'
    FROM #TMP_SIZES_PRICE_INSERT  AS tmp_insert
    LEFT JOIN M101		 			ON (
		tmp_insert.item_cd			=  M101.item_cd 
	AND	tmp_insert.color_cd			=  M101.color_cd
    AND M101.item_class_div			<> 2
    AND M101.del_flg				<> 1	
   )
   LEFT JOIN M102					ON (
		tmp_insert.item_cd			=  M102.item_cd 
	AND	tmp_insert.color_cd			=  M102.color_cd
    AND tmp_insert.size_cd			=  M102.size_cd
    AND M102.del_flg				<> 1
   )
    WHERE 
			M101.item_cd IS NULL
	AND		M102.item_cd IS NULL	
	-- CHECKOUT DUPLICATE 
	INSERT INTO @ERR_TBL
    SELECT
         N'E011'
    ,	 N'sizePrices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.item_cd' + ',' +
		 N'sizePrices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.color_cd' + ',' +
		 N'sizePrices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.size_cd' + ',' +
		 N'sizePrices.' + CONVERT(NVARCHAR, tmp_insert.idx) + '.price_list'
    ,	 0
    ,    1
    ,	 0
    ,	 N''
    ,    N'該当データが存在しません'
    FROM #TMP_SIZES_PRICE_INSERT   AS tmp_insert
    LEFT JOIN M201					 ON (
         M201.item_cd				 = tmp_insert.item_cd
	AND	 M201.color_cd				 = tmp_insert.color_cd
	AND	 M201.size_cd				 = tmp_insert.size_cd
	AND  M201.price_list			 = tmp_insert.price_list
    AND  M201.del_flg				 <> 1
    )
    WHERE 
			M201.item_cd IS NOT NULL
	AND		M201.color_cd IS NOT NULL
	AND		M201.size_cd IS NOT NULL
	AND		M201.price_list IS NOT NULL
	-- CHECKT ERROR
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
    BEGIN
		GOTO COMPLETE_QUERY
    END

	-- IF NOT ERROR --
	-- INSERT DATA @P_update_sales_prices (TYPE: JSON) TO  #TMP_SIZES_PRICE_UPDATE
	INSERT INTO #TMP_SIZES_PRICE_UPDATE
    SELECT
		 ISNULL(item_cd, SPACE(0))							AS item_cd
	,	 ISNULL(color_cd, SPACE(0))						  AS color_cd
	,	 ISNULL(size_cd, SPACE(0))						  AS size_cd
	,	 price_list	
	,    CONVERT(MONEY, ISNULL(retail_upr, 0))				AS retail_upr
    FROM OPENJSON (@P_update_sizes_prices)
    WITH (
		 item_cd					NVARCHAR(30)
    ,	 color_cd					NVARCHAR(10)
    ,	 size_cd					NVARCHAR(10)
    ,	 price_list					SMALLINT
    ,	 retail_upr					MONEY
    ) AS TMP

	-- INSERT DATA @P_delete_sizes_price (TYPE: JSON) TO  #TMP_SIZES_PRICE_DELETE
	INSERT INTO #TMP_SIZES_PRICE_DELETE
    SELECT
		 ISNULL(item_cd, SPACE(0))							AS item_cd
	,	 ISNULL(color_cd, SPACE(0))						  AS color_cd
	,	 ISNULL(size_cd, SPACE(0))						  AS size_cd
	,	 price_list	
	,    CONVERT(MONEY, ISNULL(retail_upr, 0))				AS retail_upr
    FROM OPENJSON (@P_delete_sizes_price)
    WITH (
		 item_cd					NVARCHAR(30)
    ,	 color_cd					NVARCHAR(10)
    ,	 size_cd					NVARCHAR(10)
    ,	 price_list			SMALLINT
    ,	 retail_upr					MONEY
    ) AS TMP

    -- START TRANSACTION
    BEGIN TRANSACTION
    -- TRY CATCH EXCEPTION
    BEGIN TRY
		-- DELETE TABLE SIZES PRICE
        UPDATE M201 SET
			del_user_cd					= @P_act_user_cd
        ,	del_prg						= @P_prg
        ,	del_ip						= @P_ip
        ,	del_tm						= @w_time
        ,	del_flg						= 1
        FROM M201
        INNER JOIN #TMP_SIZES_PRICE_DELETE AS tmp_delete	ON (
			M201.item_cd				= tmp_delete.item_cd		
		AND M201.price_list				= tmp_delete.price_list
		AND	M201.color_cd				= tmp_delete.color_cd
		AND M201.size_cd				= tmp_delete.size_cd
        )

		-- UPDATE TABLE SIZES PRICE
        UPDATE M201 SET
			retail_upr					= tmp_update.retail_upr
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
        FROM M201
        INNER JOIN #TMP_SIZES_PRICE_UPDATE AS tmp_update ON (
            M201.item_cd				= tmp_update.item_cd
		AND	M201.price_list				= tmp_update.price_list
		AND	M201.color_cd				= tmp_update.color_cd
		AND M201.size_cd				= tmp_update.size_cd
        )

		-- INSERT TABLE SIZES PRICE WITH CONDITION M201 DOES NOT EXIST WITH del_flg = 1
        INSERT INTO M201
        SELECT
			tmp_insert.item_cd		
		,	tmp_insert.color_cd
		,	tmp_insert.size_cd
        ,	tmp_insert.price_list					      				
        ,	tmp_insert.retail_upr						
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
        FROM #TMP_SIZES_PRICE_INSERT AS tmp_insert
        LEFT JOIN M201										ON (
			tmp_insert.item_cd					= M201.item_cd		
		AND	tmp_insert.price_list				= M201.price_list
		AND	tmp_insert.color_cd					= M201.color_cd
		AND tmp_insert.size_cd					= M201.size_cd
		)
		WHERE 
				M201.del_flg <> 1 OR M201.del_flg IS NULL
		
		-- UPDATE TABLE SIZES GET DATA TABLE #TMP_SIZES_PRICE_INSERT WITH CONDITION TABLE M201 DELETED WITH del_flg = 0
		UPDATE M201 SET
                    retail_upr					= tmp_insert.retail_upr
                  ,	cre_user_cd					= IIF(del_flg = 1, @P_act_user_cd,	cre_user_cd)
                  ,	cre_ip						= IIF(del_flg = 1, @P_ip,			cre_ip)
                  ,	cre_prg						= IIF(del_flg = 1, @P_prg,			cre_prg)
                  ,	cre_tm						= IIF(del_flg = 1, @w_time,			cre_tm)
                  ,	upd_user_cd					= IIF(del_flg = 1, NULL,			@P_act_user_cd)
                  ,	upd_ip						= IIF(del_flg = 1, NULL,			@P_ip)
                  ,	upd_prg						= IIF(del_flg = 1, NULL,			@P_prg)
                  ,	upd_tm						= IIF(del_flg = 1, NULL,			@w_time)
                  ,	del_flg						= 0
        FROM M201
        INNER JOIN #TMP_SIZES_PRICE_INSERT AS tmp_insert	ON (
			M201.item_cd						= tmp_insert.item_cd
		AND	M201.price_list						= tmp_insert.price_list
		AND	M201.color_cd						= tmp_insert.color_cd
		AND M201.size_cd						= tmp_insert.size_cd
        )
		WHERE 
				M201.del_flg = 1

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

    DROP TABLE IF EXISTS #TMP_SIZES_PRICE_INSERT
    DROP TABLE IF EXISTS #TMP_SIZES_PRICE_DELETE
    DROP TABLE IF EXISTS #TMP_SIZES_PRICE_UPDATE
END
