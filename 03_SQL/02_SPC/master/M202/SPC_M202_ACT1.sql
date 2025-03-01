SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
--
--****************************************************************************************
--* 											
--*  処理概要/process overview	:	Save data of a product cost
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	HaiNN - ANS901
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE [dbo].[SPC_M202_ACT1]
	@P_costs						NVARCHAR(MAX)	= N''
,	@P_upd_costs					NVARCHAR(MAX)	= N''
,	@P_del_costs					NVARCHAR(MAX)	= N''
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

	-- create temp tables
	CREATE TABLE #TMP_PRODUCT_COST (
		item_cd							NVARCHAR(30)
	,	color_cd						NVARCHAR(10)
	,	size_cd							NVARCHAR(10)
	,	supplier_cd						NVARCHAR(5)
	,	retail_upr						MONEY
	)
	CREATE TABLE #TMP_PRODUCT_COST_INSERT (
		idx								INT
	,	item_cd							NVARCHAR(30)
	,	color_cd						NVARCHAR(10)
	,	size_cd							NVARCHAR(10)
	,	supplier_cd						NVARCHAR(5)
	,	retail_upr						MONEY
	)
	CREATE TABLE #TMP_PRODUCT_COST_UPDATE (
		item_cd							NVARCHAR(30)
	,	color_cd						NVARCHAR(10)
	,	size_cd							NVARCHAR(10)
	,	supplier_cd						NVARCHAR(5)
	,	retail_upr						MONEY
	)
	CREATE TABLE #TMP_PRODUCT_COST_DELETE (
		item_cd							NVARCHAR(30)
	,	color_cd						NVARCHAR(10)
	,	size_cd							NVARCHAR(10)
	,	supplier_cd						NVARCHAR(5)
	)

	-- insert data to temp tables 
	INSERT INTO #TMP_PRODUCT_COST_INSERT
	SELECT
		ISNULL(idx, -1)
	,	ISNULL(item_cd, '')
	,	ISNULL(color_cd, '')
	,	ISNULL(size_cd, '')
	,	ISNULL(supplier_cd,'')
	,	CONVERT(MONEY, ISNULL(retail_upr, 0))
	FROM OPENJSON (@P_costs)
	WITH (
		idx								INT
	,	item_cd							NVARCHAR(30)
	,	color_cd						NVARCHAR(10)
	,	size_cd							NVARCHAR(10)
	,	supplier_cd						NVARCHAR(5)
	,	retail_upr						MONEY
	) AS TMP	

	INSERT INTO #TMP_PRODUCT_COST_UPDATE
    SELECT
        ISNULL(item_cd, '')
    ,   ISNULL(color_cd, '')
    ,   ISNULL(size_cd,'')
    ,   ISNULL(supplier_cd,'')
    ,   CONVERT(MONEY, ISNULL(retail_upr, 0))
    FROM OPENJSON (@P_upd_costs)
    WITH (
		item_cd								NVARCHAR(30)
    ,   color_cd							NVARCHAR(10)
    ,   size_cd								NVARCHAR(10)
    ,   supplier_cd							NVARCHAR(5)
    ,   retail_upr							MONEY
    ) AS TMP

	INSERT INTO #TMP_PRODUCT_COST_DELETE
    SELECT
        ISNULL(item_cd, '')
    ,   ISNULL(color_cd, '')
    ,   ISNULL(size_cd,'')
    ,   ISNULL(supplier_cd,'')
    FROM OPENJSON (@P_del_costs)
    WITH (
		item_cd								NVARCHAR(30)
    ,   color_cd							NVARCHAR(10)
    ,   size_cd								NVARCHAR(10)
    ,   supplier_cd							NVARCHAR(5)
    ) AS TMP

	-- check item_class_div	<> 2	
	INSERT INTO @ERR_TBL
    SELECT
            'E012'
         ,	'costs.' + CONVERT(NVARCHAR, #TMP_PRODUCT_COST_INSERT.idx) + '.item_cd'
         ,	 0
         ,   1
         ,	 0
         ,	 ''
         ,   N'該当データが存在しません'
    FROM #TMP_PRODUCT_COST_INSERT
    LEFT JOIN M101							ON (
		#TMP_PRODUCT_COST_INSERT.item_cd	= M101.item_cd
	AND	#TMP_PRODUCT_COST_INSERT.color_cd	= M101.color_cd
	AND	M101.item_class_div					<> 2
	AND	M101.del_flg						<> 1	
    )
	WHERE M101.item_cd						IS NULL

	-- check exist
	INSERT INTO @ERR_TBL
	SELECT
            'E012'
         ,	'costs.' + CONVERT(NVARCHAR, #TMP_PRODUCT_COST_INSERT.idx) + '.supplier_cd'
         ,	 0
         ,   1
         ,	 0
         ,	 ''
         ,   N'該当データが存在しません'
    FROM #TMP_PRODUCT_COST_INSERT
    LEFT JOIN M006							ON (
		#TMP_PRODUCT_COST_INSERT.supplier_cd	= M006.supplier_cd
	AND M006.supplier_div						=  1
	AND M006.del_flg							<>	1
    )
	WHERE	M006.supplier_cd					IS NULL	

	-- check exist in M202
	INSERT INTO @ERR_TBL
    SELECT
            'E011'
		,	'costs.' + CONVERT(NVARCHAR, #TMP_PRODUCT_COST_INSERT.idx) + '.item_cd,' +
			'costs.' + CONVERT(NVARCHAR, #TMP_PRODUCT_COST_INSERT.idx) + '.color_cd,' +
			'costs.' + CONVERT(NVARCHAR, #TMP_PRODUCT_COST_INSERT.idx) + '.size_cd,' +
			'costs.' + CONVERT(NVARCHAR, #TMP_PRODUCT_COST_INSERT.idx) + '.supplier_cd'
         ,	 0
         ,   1
         ,	 0
         ,	 ''
         ,   N'重複した値。'
    FROM #TMP_PRODUCT_COST_INSERT
    LEFT JOIN M202							ON (
			M202.item_cd					= #TMP_PRODUCT_COST_INSERT.item_cd
        AND M202.color_cd					= #TMP_PRODUCT_COST_INSERT.color_cd
        AND M202.size_cd					= #TMP_PRODUCT_COST_INSERT.size_cd
        AND M202.supplier_cd				= #TMP_PRODUCT_COST_INSERT.supplier_cd
		AND M202.del_flg					<> 1
    )
	WHERE 
			M202.item_cd		IS NOT NULL
	AND		M202.color_cd		IS NOT NULL
	AND		M202.size_cd		IS NOT NULL
	AND		M202.supplier_cd	IS NOT NULL
	-- has err
	IF EXISTS (SELECT 1 FROM @ERR_TBL)
    BEGIN
		GOTO COMPLETE_QUERY
    END

	-- START TRANSACTION 
	BEGIN TRANSACTION
	-- TRY CATCH EXCEPTION
	BEGIN TRY
		-- DEL
		UPDATE M202 SET
            del_user_cd						= @P_act_user_cd
        ,   del_prg							= @P_prg
        ,   del_ip							= @P_ip
        ,   del_tm							= @w_time
        ,   del_flg							= 1
        FROM M202
        INNER JOIN #TMP_PRODUCT_COST_DELETE		ON (
            M202.item_cd                = #TMP_PRODUCT_COST_DELETE.item_cd
        AND M202.color_cd				= #TMP_PRODUCT_COST_DELETE.color_cd
        AND M202.size_cd				= #TMP_PRODUCT_COST_DELETE.size_cd
        AND M202.supplier_cd			= #TMP_PRODUCT_COST_DELETE.supplier_cd
        ) 

		-- UPD
		UPDATE M202 SET
            M202.retail_upr                 = #TMP_PRODUCT_COST_UPDATE.retail_upr
        ,   cre_user_cd                     = IIF(M202.del_flg = 1, @P_act_user_cd, M202.cre_user_cd)
        ,   cre_ip                          = IIF(M202.del_flg = 1, @P_ip, M202.cre_ip)
        ,   cre_prg                         = IIF(M202.del_flg = 1, @P_prg, M202.cre_prg)
        ,   cre_tm                          = IIF(M202.del_flg = 1, @w_time, M202.cre_tm)
        ,   upd_user_cd                     = IIF(M202.del_flg = 1, NULL, @P_act_user_cd)
        ,   upd_ip                          = IIF(M202.del_flg = 1, NULL, @P_ip)
        ,   upd_prg                         = IIF(M202.del_flg = 1, NULL, @P_prg)
        ,   upd_tm                          = IIF(M202.del_flg = 1, NULL, @w_time)
        ,   del_user_cd                     = NULL
        ,   del_ip                          = NULL
        ,   del_prg                         = NULL
        ,   del_tm                          = NULL
        ,   del_flg                         = 0
        FROM M202
        INNER JOIN #TMP_PRODUCT_COST_UPDATE ON (
            M202.item_cd					= #TMP_PRODUCT_COST_UPDATE.item_cd
        AND M202.color_cd                   = #TMP_PRODUCT_COST_UPDATE.color_cd
        AND M202.size_cd					= #TMP_PRODUCT_COST_UPDATE.size_cd
        AND M202.supplier_cd				= #TMP_PRODUCT_COST_UPDATE.supplier_cd
        )

		UPDATE M202 SET
            M202.retail_upr                 = #TMP_PRODUCT_COST_INSERT.retail_upr
        ,   cre_user_cd                     = IIF(M202.del_flg = 1, @P_act_user_cd, M202.cre_user_cd)
        ,   cre_ip                          = IIF(M202.del_flg = 1, @P_ip, M202.cre_ip)
        ,   cre_prg                         = IIF(M202.del_flg = 1, @P_prg, M202.cre_prg)
        ,   cre_tm                          = IIF(M202.del_flg = 1, @w_time, M202.cre_tm)
        ,   upd_user_cd                     = IIF(M202.del_flg = 1, NULL, @P_act_user_cd)
        ,   upd_ip                          = IIF(M202.del_flg = 1, NULL, @P_ip)
        ,   upd_prg                         = IIF(M202.del_flg = 1, NULL, @P_prg)
        ,   upd_tm                          = IIF(M202.del_flg = 1, NULL, @w_time)
        ,   del_user_cd                     = NULL
        ,   del_ip                          = NULL
        ,   del_prg                         = NULL
        ,   del_tm                          = NULL
        ,   del_flg                         = 0
        FROM M202
        INNER JOIN #TMP_PRODUCT_COST_INSERT ON (
            M202.item_cd					= #TMP_PRODUCT_COST_INSERT.item_cd
        AND M202.color_cd                   = #TMP_PRODUCT_COST_INSERT.color_cd
        AND M202.size_cd					= #TMP_PRODUCT_COST_INSERT.size_cd
        AND M202.supplier_cd				= #TMP_PRODUCT_COST_INSERT.supplier_cd
        )
		WHERE M202.del_flg = 1

		-- INSERT
		INSERT INTO M202 
        SELECT
            #TMP_PRODUCT_COST_INSERT.item_cd
        ,   #TMP_PRODUCT_COST_INSERT.color_cd
        ,   #TMP_PRODUCT_COST_INSERT.size_cd
        ,   #TMP_PRODUCT_COST_INSERT.supplier_cd
        ,   #TMP_PRODUCT_COST_INSERT.retail_upr
        ,   @P_act_user_cd
        ,   @P_prg
        ,   @P_ip
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
        FROM #TMP_PRODUCT_COST_INSERT
		LEFT JOIN M202						ON (
		    M202.item_cd					= #TMP_PRODUCT_COST_INSERT.item_cd
        AND M202.color_cd					= #TMP_PRODUCT_COST_INSERT.color_cd
        AND M202.size_cd					= #TMP_PRODUCT_COST_INSERT.size_cd
        AND M202.supplier_cd				= #TMP_PRODUCT_COST_INSERT.supplier_cd
		)
		WHERE	M202.del_flg <> 1 OR M202.del_flg IS NULL

	END TRY
	BEGIN CATCH
		SET @w_prs_result	=	'NG'
		SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
								N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
								N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
								N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT  
            N'E009'
        ,   N''
        ,   0
        ,   999
        ,   0
		,	N''
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

	DROP TABLE IF EXISTS #TMP_PRODUCT_COST
	DROP TABLE IF EXISTS #TMP_PRODUCT_COST_INSERT
	DROP TABLE IF EXISTS #TMP_PRODUCT_COST_UPDATE
	DROP TABLE IF EXISTS #TMP_PRODUCT_COST_DELETE
END
