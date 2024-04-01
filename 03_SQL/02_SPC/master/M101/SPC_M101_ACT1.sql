IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M101_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M101_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M101_ACT1 '0001','01','商品名商品名商品名','','','White','','','0','0','0','0','0','','0','','[{"item_cd":"0001","color_cd":"01","size_cd":"L","discontinued_div":0,"discontinued_display_div":0,"sort_div":1},{"item_cd":"0001","color_cd":"01","size_cd":"S","discontinued_div":1,"discontinued_display_div":1,"sort_div":2}]','809','M101','172.19.0.1';
--****************************************************************************************
--* 											
--*  処理概要/process overview	:	Save data of a product
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M101_ACT1
	@P_item_cd						NVARCHAR(30)	= N''
,	@P_color_cd						NVARCHAR(10)	= N''
,	@P_item_nm						NVARCHAR(50)	= N''
,	@P_item_kn_nm					NVARCHAR(50)	= N''
,	@P_item_ab_nm					NVARCHAR(30)	= N''
,	@P_color_nm						NVARCHAR(30)	= N''
,	@P_color_kn_nm					NVARCHAR(30)	= N''
,	@P_color_ab_nm					NVARCHAR(20)	= N''
,	@P_item_class_div				SMALLINT		= 0
,	@P_process_div					SMALLINT		= 0
,	@P_category_div					SMALLINT		= 0
,	@P_material_div					SMALLINT		= 0
,	@P_supplier_cd					INT				= 0
,	@P_supplier_item_cd				NVARCHAR(10)	= N''
,	@P_tax_div						SMALLINT		= 0
,	@P_remarks						NVARCHAR(100)	= N''
,	@P_sizes						NVARCHAR(MAX)	= N''
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
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Insert'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(MAX)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N'item_cd=' + @P_item_cd + ';color_cd=' + @P_color_cd

	IF @P_supplier_cd <> 0
	BEGIN
		IF NOT EXISTS(SELECT 1 FROM M006 WITH(NOLOCK) WHERE supplier_cd = @P_supplier_cd AND del_flg <> 1)
		BEGIN
			SET @w_prs_result							=   N'NG'
			SET	@w_remarks								=	N'該当データが存在しません'

			INSERT INTO @ERR_TBL
			SELECT  
				N'E012'
			,   'supplier_cd'
			,   0
			,   1
			,   0
			,	''
			,   @w_remarks

			GOTO COMPLETE_QUERY
		END
		ELSE IF NOT EXISTS(
			SELECT 1
			FROM M006 WITH(NOLOCK)
			WHERE
				supplier_cd								= @P_supplier_cd
			AND (
				(
					@P_item_class_div					<> 2
				AND supplier_div						= 1
				)
			OR	(
					@P_item_class_div					= 2
				AND supplier_div						= 2
				)
			)
			AND del_flg									<> 1
		)
		BEGIN
			SET @w_prs_result							=   N'NG'
			SET	@w_remarks								=	N'仕入先と商品分類が相互に該当していません。'

			INSERT INTO @ERR_TBL
			SELECT  
				N'E013'
			,   'supplier_cd'
			,   0
			,   1
			,   0
			,	''
			,   @w_remarks

			GOTO COMPLETE_QUERY
		END
	END

	IF @P_supplier_cd <> 0 AND NOT EXISTS(SELECT 1 FROM M006 WITH(NOLOCK) WHERE supplier_cd = @P_supplier_cd AND del_flg <> 1)
	BEGIN
		SET @w_prs_result							=   N'NG'
		SET	@w_remarks								=	N'該当データが存在しません'

		INSERT INTO @ERR_TBL
		SELECT  
			N'E012'
		,   'supplier_cd'
		,   0
		,   1
		,   0
		,	''
		,   @w_remarks

		GOTO COMPLETE_QUERY
	END

	SET @P_color_cd = ISNULL(@P_color_cd, N'')

	IF @P_item_class_div <> 2
	BEGIN
		CREATE TABLE #TMP_SIZES (
			item_cd							NVARCHAR(30)
		,	color_cd						NVARCHAR(30)
		,	size_cd							NVARCHAR(30)
		,	discontinued_div				SMALLINT
		,	discontinued_display_div		SMALLINT
		,	sort_div						INT
		)
		CREATE TABLE #TMP_SIZES_INSERT (
			item_cd							NVARCHAR(30)
		,	color_cd						NVARCHAR(30)
		,	size_cd							NVARCHAR(30)
		,	discontinued_div				SMALLINT
		,	discontinued_display_div		SMALLINT
		,	sort_div						INT
		)
		CREATE TABLE #TMP_SIZES_UPDATE (
			item_cd							NVARCHAR(30)
		,	color_cd						NVARCHAR(30)
		,	size_cd							NVARCHAR(30)
		,	discontinued_div				SMALLINT
		,	discontinued_display_div		SMALLINT
		,	sort_div						INT
		)
		CREATE TABLE #TMP_SIZES_DELETE (
			item_cd							NVARCHAR(30)
		,	color_cd						NVARCHAR(30)
		,	size_cd							NVARCHAR(30)
		)

		INSERT INTO #TMP_SIZES
		SELECT
			ISNULL(item_cd, '')
		,	ISNULL(color_cd, '')
		,	ISNULL(size_cd, '')
		,	discontinued_div
		,	discontinued_display_div
		,	sort_div
		FROM OPENJSON (@P_sizes)
		WITH (
			item_cd							NVARCHAR(30)
		,	color_cd						NVARCHAR(30)
		,	size_cd							NVARCHAR(30)
		,	discontinued_div				SMALLINT
		,	discontinued_display_div		SMALLINT
		,	sort_div						INT
		) AS TMP

		INSERT INTO #TMP_SIZES_INSERT
		SELECT
			#TMP_SIZES.*
		FROM #TMP_SIZES
		LEFT JOIN M102 WITH(NOLOCK) ON (
			M102.item_cd		= #TMP_SIZES.item_cd
		AND M102.color_cd		= #TMP_SIZES.color_cd
		AND M102.size_cd		= #TMP_SIZES.size_cd
		)
		WHERE
			M102.item_cd		IS NULL

		INSERT INTO #TMP_SIZES_UPDATE
		SELECT
			#TMP_SIZES.*
		FROM #TMP_SIZES
		INNER JOIN M102 WITH(NOLOCK) ON (
			M102.item_cd		= #TMP_SIZES.item_cd
		AND M102.color_cd		= #TMP_SIZES.color_cd
		AND M102.size_cd		= #TMP_SIZES.size_cd
		)

		INSERT INTO #TMP_SIZES_DELETE
		SELECT
			M102.item_cd
		,	M102.color_cd
		,	M102.size_cd
		FROM M102
		LEFT JOIN #TMP_SIZES WITH(NOLOCK) ON (
			M102.item_cd		= #TMP_SIZES.item_cd
		AND M102.color_cd		= #TMP_SIZES.color_cd
		AND M102.size_cd		= #TMP_SIZES.size_cd
		)
		WHERE
			M102.item_cd		= @P_item_cd
		AND M102.color_cd		= @P_color_cd
		AND M102.del_flg		<> 1
		AND #TMP_SIZES.item_cd	IS NULL

	END

	IF EXISTS(SELECT 1 FROM M101 WITH(NOLOCK) WHERE item_cd = @P_item_cd AND color_cd = @P_color_cd AND del_flg <> 1)
	BEGIN
		SET @w_prs_mode = 'Update'
	END

	-- START TRANSACTION 
	BEGIN TRANSACTION
	-- TRY CATCH EXCEPTION
	BEGIN TRY
		IF EXISTS(SELECT 1 FROM M101 WITH(NOLOCK) WHERE item_cd = @P_item_cd AND color_cd = @P_color_cd)
		BEGIN
			UPDATE M101 SET
				item_nm					= @P_item_nm
			,	item_kn_nm				= @P_item_kn_nm
			,	item_ab_nm				= @P_item_ab_nm
			,	color_nm				= @P_color_nm
			,	color_kn_nm				= @P_color_kn_nm
			,	color_ab_nm				= @P_color_ab_nm
			,	item_class_div			= @P_item_class_div
			,	process_div				= @P_process_div
			,	category_div			= @P_category_div
			,	material_div			= @P_material_div
			,	supplier_cd				= @P_supplier_cd
			,	supplier_item_cd		= @P_supplier_item_cd
			,	tax_div					= @P_tax_div
			,	remarks					= @P_remarks
			,	cre_user_cd				= IIF(del_flg = 1, @P_act_user_cd,	cre_user_cd)
			,	cre_ip					= IIF(del_flg = 1, @P_ip,			cre_ip)
			,	cre_prg					= IIF(del_flg = 1, @P_prg,			cre_prg)
			,	cre_tm					= IIF(del_flg = 1, @w_time,			cre_tm)
			,	upd_user_cd				= IIF(del_flg = 1, NULL,			@P_act_user_cd)
			,	upd_ip					= IIF(del_flg = 1, NULL,			@P_ip)
			,	upd_prg					= IIF(del_flg = 1, NULL,			@P_prg)
			,	upd_tm					= IIF(del_flg = 1, NULL,			@w_time)
			,	del_user_cd				= NULL
			,	del_ip					= NULL
			,	del_prg					= NULL
			,	del_tm					= NULL
			,	del_flg					= 0
			WHERE
				item_cd = @P_item_cd
			AND color_cd = @P_color_cd
		END
		ELSE
		BEGIN
			INSERT INTO M101
			SELECT
				@P_item_cd
			,	@P_color_cd
			,	@P_item_nm
			,	@P_item_kn_nm
			,	@P_item_ab_nm
			,	@P_color_nm
			,	@P_color_kn_nm
			,	@P_color_ab_nm
			,	@P_item_class_div
			,	@P_process_div
			,	@P_category_div
			,	@P_material_div
			,	@P_supplier_cd
			,	@P_supplier_item_cd
			,	@P_tax_div
			,	@P_remarks
			,	@P_act_user_cd
			,	@P_prg
			,	@P_ip
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
		END
		IF @P_item_class_div <> 2
		BEGIN
			UPDATE M102 SET
				del_user_cd				= @P_act_user_cd
			,	del_prg					= @P_prg
			,	del_ip					= @P_ip
			,	del_tm					= @w_time
			,	del_flg					= 1
			FROM M102
			INNER JOIN #TMP_SIZES_DELETE ON (
				M102.item_cd			= #TMP_SIZES_DELETE.item_cd
			AND M102.color_cd			= #TMP_SIZES_DELETE.color_cd
			AND M102.size_cd			= #TMP_SIZES_DELETE.size_cd
			)

			UPDATE M102 SET
				sort_div				= #TMP_SIZES_UPDATE.sort_div
			,	discontinued_div		= #TMP_SIZES_UPDATE.discontinued_div
			,	discontinued_display_div= #TMP_SIZES_UPDATE.discontinued_display_div
			,	cre_user_cd				= IIF(del_flg = 1, @P_act_user_cd,	cre_user_cd)
			,	cre_ip					= IIF(del_flg = 1, @P_ip,			cre_ip)
			,	cre_prg					= IIF(del_flg = 1, @P_prg,			cre_prg)
			,	cre_tm					= IIF(del_flg = 1, @w_time,			cre_tm)
			,	upd_user_cd				= IIF(del_flg = 1, NULL,			@P_act_user_cd)
			,	upd_ip					= IIF(del_flg = 1, NULL,			@P_ip)
			,	upd_prg					= IIF(del_flg = 1, NULL,			@P_prg)
			,	upd_tm					= IIF(del_flg = 1, NULL,			@w_time)
			,	del_user_cd				= NULL
			,	del_ip					= NULL
			,	del_prg					= NULL
			,	del_tm					= NULL
			,	del_flg					= 0
			FROM M102
			INNER JOIN #TMP_SIZES_UPDATE ON (
				M102.item_cd			= #TMP_SIZES_UPDATE.item_cd
			AND M102.color_cd			= #TMP_SIZES_UPDATE.color_cd
			AND M102.size_cd			= #TMP_SIZES_UPDATE.size_cd
			)

			INSERT INTO M102
			SELECT
				#TMP_SIZES_INSERT.item_cd
			,	#TMP_SIZES_INSERT.color_cd
			,	#TMP_SIZES_INSERT.size_cd
			,	#TMP_SIZES_INSERT.sort_div
			,	#TMP_SIZES_INSERT.discontinued_div
			,	#TMP_SIZES_INSERT.discontinued_display_div
			,	@P_act_user_cd
			,	@P_prg
			,	@P_ip
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
			FROM #TMP_SIZES_INSERT
		END
		ELSE
		BEGIN
			UPDATE M102 SET
				del_user_cd				= @P_act_user_cd
			,	del_prg					= @P_prg
			,	del_ip					= @P_ip
			,	del_tm					= @w_time
			,	del_flg					= 1
			WHERE
				item_cd					= @P_item_cd
			AND color_cd				= @P_color_cd
		END
	END TRY
	BEGIN CATCH
		SET @w_prs_result	=	'NG'
		SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
								N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
								N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
								N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
		SELECT @w_remarks
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

	DROP TABLE IF EXISTS #TMP_SIZES
	DROP TABLE IF EXISTS #TMP_SIZES_INSERT
	DROP TABLE IF EXISTS #TMP_SIZES_UPDATE
	DROP TABLE IF EXISTS #TMP_SIZES_DELETE
END
GO
