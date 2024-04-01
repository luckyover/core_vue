IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M101_INQ2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M101_INQ2
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M101_INQ2 '','','','','0','0','0','0','0','50','1','item_cd','ASC','809','M101','172.19.0.1';
--****************************************************************************************	
--*   											
--*  処理概要/process overview	:	Search list of items
--*  
--*  作成日/create date			:	2024/02/26
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M101_INQ2
	@P_item_cd						NVARCHAR(50)	= N''
,	@P_item_nm						NVARCHAR(50)	= N''
,	@P_color_cd						NVARCHAR(50)	= N''
,	@P_color_nm						NVARCHAR(50)	= N''
,	@P_item_class_div				INT				= 0
,	@P_process_div					INT				= 0
,	@P_category_div					INT				= 0
,	@P_supplier_cd					INT				= 0
,	@P_remove_process				BIT				= 0
,	@P_page_size					INT				= 50
,	@P_page							INT				= 1
,	@P_sort_column					NVARCHAR(50)	= N'item_cd'
,	@P_sort_type					NVARCHAR(10)	= N'ASC'
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
		@w_totalRecord				INT = 0
	,	@w_maxPage					INT = 0
	,	@w_offset					INT = 0
	,	@w_sql						NVARCHAR(MAX)

	CREATE TABLE #M101_TMP (
		item_cd						NVARCHAR(50)
	,	color_cd					NVARCHAR(50)
	,	item_nm						NVARCHAR(50)
	,	item_kn_nm					NVARCHAR(50)
	,	item_ab_nm					NVARCHAR(50)
	,	color_nm					NVARCHAR(50)
	,	color_kn_nm					NVARCHAR(50)
	,	color_ab_nm					NVARCHAR(50)
	,	item_class_div_nm			NVARCHAR(50)
	,	process_div_nm				NVARCHAR(50)
	,	category_div_nm				NVARCHAR(50)
	,	supplier_item_cd			NVARCHAR(50)
	,	supplier_cd					INT
	,	supplier_nm					NVARCHAR(50)
	)

	INSERT INTO #M101_TMP
	SELECT
		M101.item_cd
	,   M101.color_cd
	,   M101.item_nm
	,   M101.item_kn_nm
	,   M101.item_ab_nm
	,   M101.color_nm
	,   M101.color_kn_nm
	,   M101.color_ab_nm
	,   item_class_div.[name]
	,   process_div.[name]
	,   category_div.[name]
	,   M101.supplier_item_cd
	,   M006.supplier_cd
	,   M006.supplier_nm
	FROM M101 WITH(NOLOCK)
	LEFT JOIN M401						AS item_class_div WITH(NOLOCK)			ON (
		M101.item_class_div				= item_class_div.name_cd
	AND item_class_div.name_div			= 'item_class_div'
	)
	LEFT JOIN M401						AS process_div WITH(NOLOCK)		ON (
		M101.process_div				= process_div.name_cd
	AND process_div.name_div			= 'processing_type_div'
	)
	LEFT JOIN M401						AS category_div WITH(NOLOCK)		ON (
		M101.category_div				= category_div.name_cd
	AND category_div.name_div			= 'category_div'
	)
	LEFT JOIN M006						WITH(NOLOCK)		ON (
		M101.supplier_cd				= M006.supplier_cd
	AND M006.del_flg					<> 1
	)
	WHERE (
		@P_item_cd						= ''
	OR	M101.item_cd					LIKE '%' + @P_item_cd + '%'
	)
	AND (
		@P_item_nm						= ''
	OR	M101.item_nm					LIKE '%' + @P_item_nm + '%'
	OR	M101.item_kn_nm					LIKE '%' + @P_item_nm + '%'
	OR	M101.item_ab_nm					LIKE '%' + @P_item_nm + '%'
	)
	AND (
		@P_color_cd						= ''
	OR	M101.color_cd					LIKE '%' + @P_color_cd + '%'
	)
	AND (
		@P_color_nm						= ''
	OR	M101.color_nm					LIKE '%' + @P_color_nm + '%'
	OR	M101.color_kn_nm				LIKE '%' + @P_color_nm + '%'
	OR	M101.color_ab_nm				LIKE '%' + @P_color_nm + '%'
	)
	AND (
		ISNULL(@P_supplier_cd, 0)		= 0
	OR	M006.supplier_cd				= @P_supplier_cd
	)
	AND (
		(
			@P_item_class_div			= 0
		AND (
				@P_remove_process		= 0
			OR	M101.item_class_div		<> 2
			)
		)
	OR	(
			@P_item_class_div			<> 0
		AND M101.item_class_div			= @P_item_class_div
		)
	)
	AND (
		@P_process_div					= 0
	OR	M101.process_div				= @P_process_div
	)
	AND (
		@P_category_div					= 0
	OR	M101.category_div				= @P_category_div
	)
	AND M101.del_flg					<> 1

	SELECT @w_totalRecord = COUNT(item_cd) FROM #M101_TMP
	SET @w_maxPage = @w_totalRecord / @P_page_size + IIF(@w_totalRecord % @P_page_size > 0, 1, 0)
	IF @P_page > @w_maxPage
	BEGIN
		SET @P_page = @w_maxPage
	END
	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	SET @w_offset = (@P_page - 1) * @P_page_size

	SET @w_sql = 
		'SELECT
			*
		FROM #M101_TMP
		ORDER BY
		' +	ISNULL(NULLIF(@P_sort_column, ''), 'item_cd') + ' '  + ISNULL(NULLIF(@P_sort_type, ''), 'ASC') +
		IIF(
			ISNULL(NULLIF(@P_sort_column, ''), 'item_cd') = 'item_cd'
		,	', color_cd ASC'
		,	''
		) + '
		OFFSET ' + CONVERT(NVARCHAR, @w_offset) + '
		ROWS FETCH NEXT ' + CONVERT(NVARCHAR, @P_page_size) + ' ROWS ONLY'
	EXEC(@w_sql)

	SELECT
		@w_totalRecord		AS totalRecord
	,	@P_page				AS [page]
	,	@P_page_size		AS pageSize

	DROP TABLE IF EXISTS #M101_TMP
END
GO
