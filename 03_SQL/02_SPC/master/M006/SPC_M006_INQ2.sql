IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M006_INQ2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M006_INQ2
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M006_INQ2 '0','0','','','','','0','0','0','50','1','supplier_cd','ASC','809','M101','172.19.0.1';
--****************************************************************************************	
--*   											
--*  処理概要/process overview	:	Search list of supplier
--*  
--*  作成日/create date			:	2024/02/24
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M006_INQ2
	@P_supplier_cd					INT				= 0
,	@P_supplier_div					INT				= 0
,	@P_supplier_nm					NVARCHAR(50)	= N''
,	@P_supplier_kn_nm				NVARCHAR(50)	= N''
,	@P_supplier_ab_nm				NVARCHAR(30)	= N''
,	@P_supplier_tel					NVARCHAR(20)	= N''
,	@P_supplier_class_div1			INT				= 0
,	@P_supplier_class_div2			INT				= 0
,	@P_supplier_class_div3			INT				= 0
,	@P_page_size					INT				= 50
,	@P_page							INT				= 1
,	@P_sort_column					NVARCHAR(50)	= N'supplier_cd'
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

	CREATE TABLE #M006_TMP (
		supplier_cd					INT
	,	supplier_nm					NVARCHAR(50)
	,	supplier_kn_nm				NVARCHAR(50)
	,	supplier_ab_nm				NVARCHAR(30)
	,	supplier_div_nm				NVARCHAR(30)
	,	supplier_mail_address		NVARCHAR(255)
	,	supplier_tel				NVARCHAR(20)
	,	supplier_class_div1_nm		NVARCHAR(50)
	,	supplier_class_div2_nm		NVARCHAR(50)
	,	supplier_class_div3_nm		NVARCHAR(50)
	)

	INSERT INTO #M006_TMP
	SELECT
		M006.supplier_cd
	,   M006.supplier_nm
	,   M006.supplier_kn_nm
	,   M006.supplier_ab_nm
	,   supplier_div.[name]
	,   M006.supplier_mail_address
	,   M006.supplier_tel
	,   supplier_class_div1.[name]
	,   supplier_class_div2.[name]
	,   supplier_class_div3.[name]
	FROM M006 WITH(NOLOCK)
	LEFT JOIN M401						AS supplier_div WITH(NOLOCK)			ON (
		M006.supplier_div				= supplier_div.name_cd
	AND supplier_div.name_div			= 'supplier_div'
	)
	LEFT JOIN M401						AS supplier_class_div1 WITH(NOLOCK)		ON (
		M006.supplier_class_div1		= supplier_class_div1.name_cd
	AND supplier_class_div1.name_div	= 'supplier_class_div1'
	)
	LEFT JOIN M401						AS supplier_class_div2 WITH(NOLOCK)		ON (
		M006.supplier_class_div2		= supplier_class_div2.name_cd
	AND supplier_class_div2.name_div	= 'supplier_class_div2'
	)
	LEFT JOIN M401						AS supplier_class_div3 WITH(NOLOCK)		ON (
		M006.supplier_class_div3		= supplier_class_div3.name_cd
	AND supplier_class_div3.name_div	= 'supplier_class_div3'
	)
	WHERE (
		@P_supplier_cd					= 0
	OR	M006.supplier_cd				= @P_supplier_cd
	)
	AND (
		@P_supplier_nm					= ''
	OR	M006.supplier_nm				LIKE '%' + @P_supplier_nm + '%'
	)
	AND (
		@P_supplier_kn_nm				= ''
	OR	M006.supplier_kn_nm				LIKE '%' + @P_supplier_kn_nm + '%'
	)
	AND (
		@P_supplier_ab_nm				= ''
	OR	M006.supplier_ab_nm				LIKE '%' + @P_supplier_ab_nm + '%'
	)
	AND (
		@P_supplier_tel					= ''
	OR	M006.supplier_tel				LIKE '%' + @P_supplier_tel + '%'
	)
	AND (
		@P_supplier_div					= 0
	OR	M006.supplier_div				= @P_supplier_div
	)
	AND (
		@P_supplier_class_div1			= 0
	OR	M006.supplier_class_div1		= @P_supplier_class_div1
	)
	AND (
		@P_supplier_class_div2			= 0
	OR	M006.supplier_class_div2		= @P_supplier_class_div2
	)
	AND (
		@P_supplier_class_div3			= 0
	OR	M006.supplier_class_div3		= @P_supplier_class_div3
	)
	AND M006.del_flg					<> 1

	SELECT @w_totalRecord = COUNT(supplier_cd) FROM #M006_TMP
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
		FROM #M006_TMP
		ORDER BY
		' +	ISNULL(NULLIF(@P_sort_column, ''), 'supplier_cd') + ' '  + ISNULL(NULLIF(@P_sort_type, ''), 'ASC') + '
		OFFSET ' + CONVERT(NVARCHAR, @w_offset) + '
		ROWS FETCH NEXT ' + CONVERT(NVARCHAR, @P_page_size) + ' ROWS ONLY'
	EXEC(@w_sql)

	SELECT
		@w_totalRecord		AS totalRecord
	,	@P_page				AS [page]
	,	@P_page_size		AS pageSize

	DROP TABLE IF EXISTS #M006_TMP
END
GO
